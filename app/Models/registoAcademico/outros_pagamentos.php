<?php

namespace App\Models\registoAcademico;

use App\Helpers\ReferenciaBCIHelper;
use App\Helpers\ReferenciaBIMHelper;
use App\Models\detalhestabelavalores;
use App\Models\metodo_pagamento;
use App\Models\referenciasbancaria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class outros_pagamentos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="outros_pagamentos";
    protected $fillable=[
        "aluno_classe_id",
        "mes_id",
        "tipo_pagamento_id",
        "data_inicio",
        "data_Fim",
    "Estado",
"metodo_pagamento_id",
"usuario_Atualizou",
"usuario_registou",
"referencia",
'multaActiva',
"Multa",
"Ntalao"


    ];



 public function TBdetalhes(){
    return $this->hasMany(detalhestabelavalores::class,"idtabelavalores","tipo_pagamento_id");
 }

 public function alunoclasse(){
    return $this->hasOne(alunoClasse::class,"id","aluno_classe_id");
 }

 public function mes(){
    return $this->hasOne(meses::class,"id","mes_id");
 }

 public function metodopagamento(){
    return $this->hasOne(metodo_pagamento::class,"id","metodo_pagamento_id");
 }







protected static function boot()
{
    parent::boot();

    static::saving(function ($outros_pagamentos) {
        // Buscar a classe do aluno
        $alunoClasse = alunoClasse::find($outros_pagamentos->aluno_classe_id);
        if (!$alunoClasse) return;

        $codigoAC = $alunoClasse->codigo_AC;

        // Buscar tipo de pagamento
        $tipoPagamento = DB::table('detalhestabelavaores')
            ->where('id', $outros_pagamentos->tipo_pagamento_id)
            ->where('classe_id', $alunoClasse->classe_id)
            ->where('anolectivo_id', $alunoClasse->anolectivo_id)
            ->where('mes', $outros_pagamentos->mes_id)
            ->first();

			//dd($tipoPagamento,$outros_pagamentos);
        if (!$tipoPagamento) return;

        // Buscar ano e último dígito
        $ano = anolectivo::find($alunoClasse->anolectivo_id)?->anolectivo ?? now()->year;
        $ultimoDigitoAno = substr((string) $ano, -1);

        // Meses
        $mesIdOriginal = Carbon::parse($tipoPagamento->limite)->format('m');
        $mesCorrespondente = DB::table("corespondeciameses")->where("id", $mesIdOriginal)->first()?->ccorespondente_ID;

        // Valores
        $valorBase =(int) $tipoPagamento->valorDescricao;
        $multa = ($tipoPagamento->multa / 100) * $valorBase;
        $valorComMulta = $valorBase + $multa;

        // Bancos disponíveis
        $metodos = DB::table('metodo_pagamento')->where('tipo', '>', 0)->get();
        $bancos = DB::table('bancos')->whereIn('id', $metodos->pluck('tipo'))->get();

        foreach ($bancos as $banco) {
            $entidade = $banco->Entidade;
            $mes1=0;
            $multa1=null;
            $multa2=null;
            $mes2=0;
  if($tipoPagamento->multa!=0){
            $mes1 = str_pad($mesIdOriginal, 2, '0', STR_PAD_LEFT);
            $mes2 = str_pad($mesCorrespondente, 2, '0', STR_PAD_LEFT);
            $multa1=0;
            $multa2=1;
  }
            $codigoBase = $tipoPagamento->tipo.$codigoAC;

            $referencias = collect();

            if ($banco->descricao === 'BIM') {
                //$ref1 = ReferenciaBIMHelper::gerarReferenciaComCheckDigit($entidade, $codigoBase . $mes1, $valorBase);
                //$ref2 = ReferenciaBIMHelper::gerarReferenciaComCheckDigit($entidade, $codigoBase .$mes2, $valorComMulta);

              $ref1= ReferenciaBIMHelper::gerarReferencia($entidade,$tipoPagamento->tipo.$codigoAC,$mes1,(int)$valorBase);
              $ref2= ReferenciaBIMHelper::gerarReferencia($entidade,$tipoPagamento->tipo.$codigoAC,$mes2,(int)$valorComMulta);
            } elseif ($banco->descricao === 'BCI') {
                $ref1 = ReferenciaBCIHelper::gerarReferencia($entidade, $codigoBase, $mes1,(int) $valorBase);
                $ref2 = ReferenciaBCIHelper::gerarReferencia($entidade, $codigoBase, $mes2, (int)$valorComMulta);
            } else {
                continue;
            }

            $referencias->push(["refe" => $ref1, "multa" => $multa1]);
            $referencias->push(["refe" => $ref2, "multa" => $multa2]);

            foreach ($referencias as $item) {
                referenciasbancaria::updateOrCreate(
                    [
                        "tipo_pagamento_id" => $outros_pagamentos->tipo_pagamento_id,
                        "referencia" => $item["refe"],
                        "aluno_classe_id" => $alunoClasse->id,
                        "mes_id" => $tipoPagamento->mes
                    ],
                    [
                        "banco_id" => $banco->id,
                        "Multa" => $item["multa"]
                    ]
                );
            }
        }
    });


}
}







<?php

namespace App\Models\registoAcademico;

use App\Helpers\ReferenciaBCIHelper;
use App\Helpers\ReferenciaBIMHelper;
use App\Models\Admin\tipossaida;
use App\Models\Admin\tranferencias_disistencias;
use App\Models\detalhestabelavalores;
use App\Models\metodo_pagamento;
use App\Models\referenciasbancaria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\registoAcademico\Aluno;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\anolectivo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class alunoClasse extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="aluno_classes";
    protected $fillable=[
        "aluno_id",
        "classe_id",
        "anolectivo_id",
        "estado",
        'Multa',
        'multaActiva',
        'metodo_pagamento',
        'usuario_registou',
        'tipo_Pagamento_id',
        'referencia',
        'FormulaMendia',
        'codigo_AC',
        "Ntalao",



    ];

 public function TBdetalhes(){
    return $this->hasOne(detalhestabelavalores::class,"idtabelavalores","tipo_Pagamento_id");
 }


 public function mes(){
    return meses::where("Descricao","Anual")->first();
 }

 public function metodopagamento(){
    return $this->hasOne(metodo_pagamento::class,"id","metodo_pagamento");
 }
    public function classesAluno()
    {
        return $this->hasOne(alunoClasse::class, 'id', 'classe_id');
    }


    public function Aluno()
    {
        return $this->hasOne(Aluno::class, 'id', 'aluno_id');
    }
    public function formulamediaAnual()
    {
        return $this->hasOne(mediaanual::class, 'id', 'FormulaMedia');
    }
/**
 * Get all of the comments for the alunoClasse
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function Alunos()
{
    return $this->hasMany(Aluno::class, 'id', 'aluno_id');
}

    public function classe()
    {
        return $this->hasOne(classe::class, 'id', 'classe_id');
    }

public function anolectivo()
    {
        return $this->hasOne(anolectivo::class, 'id', 'anolectivo_id');
    }



    public function mensalidades()
    {
        return $this->hasMany(outros_pagamentos::class, 'aluno_classe_id', 'id');
    }
 public function tiposaida()
    {
        return $this->hasMany(tranferencias_disistencias::class, 'aluno_classe_id', 'id');
    }

 public function turma()
    {
        return $this->hasOne(turma_aluno::class, 'aluno_classe_id', 'id');
    }

public function tabelavalor()
    {
        return $this->hasOne(tabela_valore::class, 'id', 'tipo_Pagamento_id');
    }


protected static function boot()
{
    parent::boot();


    static::creating(function ($alunoclasse) {
        $ano = anolectivo::find($alunoclasse->anolectivo_id)?->anolectivo ?? now()->year;
        $ultimoDigitoAno = substr((string) $ano, -1);

        if (!$alunoclasse->classe_id) {
            throw new \Exception('Classe do aluno não definida.');
        }

        $quantidade = alunoClasse::where("anolectivo_id", $alunoclasse->anolectivo_id)
            ->where('classe_id', $alunoclasse->classe_id)
            ->count() + 1;

        $classeFormatada = str_pad($alunoclasse->classe_id, 2, '0', STR_PAD_LEFT);
        $sequencial = str_pad($quantidade, 3, '0', STR_PAD_LEFT);
        $codigoBase = $ultimoDigitoAno . $classeFormatada . $sequencial;

        // Garante que o código seja único
        while (DB::table('aluno_classes')->where('codigo_AC', $codigoBase)->exists()) {
            $quantidade++;
            $sequencial = str_pad($quantidade, 3, '0', STR_PAD_LEFT);
            $codigoBase = $ultimoDigitoAno . $classeFormatada . $sequencial;
        }

        $alunoclasse->codigo_AC = $codigoBase;

        $dadosItem=alunoClasse::where("anolectivo_id", $alunoclasse->anolectivo_id)
            ->count() + 1;
        // $alunoclasse->Ntalao = str_pad($dadosItem, 4, '0', STR_PAD_LEFT);
    });


      static::saved(function ($alunoclasse) {

        // Busca o tipo de pagamento padrão para a classe e ano letivo
        $tipopagamento = DB::table('detalhestabelavaores')
            ->where('id', $alunoclasse->tipo_Pagamento_id)
            ->where('classe_id', $alunoclasse->classe_id)
            ->where('anolectivo_id', $alunoclasse->anolectivo_id)
            ->first();

            // dd($tipopagamento);

// Corespondencia
            $codigoBase=$alunoclasse->codigo_AC;
 // Busca métodos de pagamento válidos e os bancos associados
        $metodos = DB::table('metodo_pagamento')->where('tipo', '>', 0)->get();
        $bancos = DB::table('bancos')->whereIn('id', $metodos->pluck('tipo')->toArray())->get();

        // Calcula o valor a pagar incluindo multa, se aplicável
        $valorApagar = 0;
        $multaactiva = $alunoclasse->multaActiva;

       $limite = Carbon::parse($tipopagamento->limite);
            $valorBase = $tipopagamento->valorDescricao;
            $multa = $alunoclasse->Multa;
            $valorApagar = $valorBase + $multa;


        $mes1 = Carbon::parse($tipopagamento->limite)->format('m');
        $mes2 = DB::table("corespondeciameses")->where("id", $mes1)->first()?->ccorespondente_ID;

        foreach ($bancos as $banco) {
            $entidade = $banco->Entidade;
    // Finaliza o código com tipo de pagamento e ano

            $mes1 = str_pad($mes1, 2, '0', STR_PAD_LEFT);
            $mes2 = str_pad($mes2, 2, '0', STR_PAD_LEFT);
            $codigoBase1 = $tipopagamento->tipo.$codigoBase;
          // Gera a referência conforme o banco

          $referencias=collect();
            if ($banco->descricao === 'BIM') {
                //$referencia = ReferenciaBIMHelper::gerarReferenciaComCheckDigit($entidade, $codigoBase1 . $mes1, $valorBase);
                $referencia = ReferenciaBIMHelper::gerarReferencia($entidade,$tipopagamento->tipo.$codigoBase,$mes1,$valorBase);
                $referencia2 = ReferenciaBIMHelper::gerarReferencia($entidade,$tipopagamento->tipo.$codigoBase,$mes2,$valorApagar);
               // $referencia2 = ReferenciaBIMHelper::gerarReferenciaComCheckDigit($entidade, $codigoBase1 . $mes2, $valorApagar);
                //$referencia2 = ReferenciaBIMHelper::gerarReferenciaComCheckDigit($entidade, $codigoBase1 . $mes2, $valorApagar);

                $referencias->push(["refe"=>$referencia,"multa"=>0]);
             $referencias->push(["refe"=>$referencia2,"multa"=>1]);
             //$referencias->push($referencia2);

             foreach($referencias as $referenciaItem):
                referenciasbancaria::updateOrCreate(
                [
        "tipo_pagamento_id"=>$alunoclasse->tipo_Pagamento_id,
        "referencia"=>$referenciaItem["refe"],
        "aluno_classe_id"=>$alunoclasse->id,
        "mes_id"=>$tipopagamento->mes],["banco_id"=>$banco->id,
        "Multa" =>$referenciaItem["multa"]] );
                endforeach;


            } elseif ($banco->descricao === 'BCI') {
                $referencia = ReferenciaBCIHelper::gerarReferencia($entidade, $codigoBase1, $mes1, $valorBase);
                $referencia2 = ReferenciaBCIHelper::gerarReferencia($entidade, $codigoBase1, $mes2, $valorApagar);

                $referencias->push(["refe"=>$referencia,"multa"=>0]);
             $referencias->push(["refe"=>$referencia2,"multa"=>1]);
             //$referencias->push($referencia2);

             foreach($referencias as $referenciaItem):
                referenciasbancaria::updateOrCreate(
                [
        "tipo_pagamento_id"=>$alunoclasse->tipo_Pagamento_id,
        "referencia"=>$referenciaItem["refe"],
        "aluno_classe_id"=>$alunoclasse->id,
        "mes_id"=>$tipopagamento->mes],["banco_id"=>$banco->id,"Multa" =>$referenciaItem["multa"]] );
                endforeach;
            }
        }

        // Armazena as referências como JSON no modelo
        //$alunoclasse->referencia = json_encode($referencias);
    });
}
}

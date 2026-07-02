<?php

namespace App\Http\Controllers\registoAcademico;

use App\Exports\ModeloImportacaoPagamentos;
use App\Http\Controllers\Controller;
use App\Imports\alunosImport;
use App\Models\Admin\observadorSys;
use App\Models\Admin\tipossaida;
use App\Models\Admin\tranferencias_disistencias;
use App\Models\detalhestabelavalores;
use App\Models\modelmpesapay;
use App\Models\registoAcademico\Aluno;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\contacto;
use App\Models\registoAcademico\distrito;
use App\Models\registoAcademico\Doenca;
use App\Models\registoAcademico\encaregado;
use App\Models\registoAcademico\endereco;
use App\Models\registoAcademico\grauparentesco;
use App\Models\registoAcademico\mensalidade;
use App\Models\registoAcademico\meses;
use App\Models\registoAcademico\outros_pagamentos;
use App\Models\registoAcademico\pais;
use App\Models\registoAcademico\profissao;
use App\Models\registoAcademico\provincia;
use App\Models\registoAcademico\religiao;
use App\Models\registoAcademico\tipos_pagamentos;
use App\Services\MpesaService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Spipu\Html2Pdf\Html2Pdf;

class alunosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $religiao;

    protected $profissao;

    protected $doencas;

    protected $classes;

    protected $grauparentesco;

    protected $alunosInscritos;

    protected $alunosInscritosTodoas;

    protected $MpesaService;
    protected $ano;
    protected $tipopagamento;
    protected const COLUNAS_FIXAS = 7;


    public function __construct(religiao $religiao, profissao $profissao,
        Doenca $doencas, classe $classe,
        grauparentesco $grauparentesco, Aluno $alunosInscritos, MpesaService $MpesaService)
    {
        $this->religiao = $religiao;
        $this->profissao = $profissao;
        $this->doencas = $doencas;
        $this->classes = $classe;
        $this->grauparentesco = $grauparentesco;
        $this->alunosInscritos = $alunosInscritos;
        $this->MpesaService = $MpesaService;
        $dados = collect();

    }

    public function saidaTran(Request $request)
    {

        $tipoSaisa = tipossaida::where('id', $request->TiposaidaSelect)->first();


//  dd($request->all(), $tipoSaisa );

        if ($request->TiposaidaSelect == 100) {

            tranferencias_disistencias::where(
                'aluno_classe_id', $request->idAluno)->forceDelete();
            alunoClasse::where('id', $request->idAluno)->update(['Estado' => $tipoSaisa->Descricao]);

            outros_pagamentos::where('aluno_classe_id', $request->idAluno)->restore();
        } else {

            tranferencias_disistencias::updateOrCreate(
                ['aluno_classe_id' => $request->idAluno],

                ['aluno_classe_id' => $request->idAluno, 'tipo_id' => $tipoSaisa->id, 'mes_id' => $request->mes_id]

            );
            alunoClasse::where('id', $request->idAluno)->update(
                ['Estado' => $tipoSaisa->Descricao]);

            outros_pagamentos::where('aluno_classe_id', $request->idAluno)->where('Estado', '!=', 'Pago')->delete();
        }

        return redirect()->route('aluno.index');
    }

    public function index()
    {
       $extrno ="Visualizar-".trim(DB::table("tipos_pagamentos")->where("id",1)->first()->Descricao);
         $interno ="Visualizar-".trim(DB::table("tipos_pagamentos")->where("id",2)->first()->Descricao);

        //  dd($extrno, $interno);
         if (auth()->user()->can($extrno)||
         auth()->user()->can($interno)
         ||auth()->user()->can('Ver-Aluno')
         ||auth()->user()->can('Modificar-Estado')
         ||auth()->user()->can('Editar-Aluno')
         ) {


            // $anofrequenca = alunoClasse::distinct()->get('anolectivo_id');
            // // dd($anofrequenca);
            // $alunosInscritos = $this->alunosInscritos;

            $claases = classe::all();
            $anos = anolectivo::all();

            return view('registoAcademico.Alunos-inscrito-select', compact('claases', 'anos'));

        } else {
            return redirect('/home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (auth()->user()->can('Efetuar-MATRICULA EXTERNOS')) {
            $religiao = $this->religiao->all();
            $profissao = $this->profissao->all();
            $doencasCronicas = $this->doencas->all();
            $classes = $this->classes->all();
            $grauparentesco = $this->grauparentesco->all();
            $anolelctivo = DB::select('SELECT * FROM anolectivos ORDER BY id DESC ');
            $metodo = DB::table('metodo_pagamento')->get();

            $tabelavaloresano = DB::table('tabelavaloresano')->get();

            return view('registoAcademico.aluno-matricula',
                compact('religiao', 'profissao', 'doencasCronicas', 'classes', 'grauparentesco', 'anolelctivo', 'metodo', 'tabelavaloresano'));
        } else {
            $mensagem = 'nao possue a permissao de Realizar Matricula';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {

        $resul = '';
        $talaoNumero = $this->talao($request->tipopagamento, $request->ano_lectivo);

        $multa = $request->input('multaAct', 0);
        if ($multa == 'undefined') {
            $multa = 0;
        }

        // dd($request->all());

        // dd($multa);
        $Referenciadepagamento = null;

        if (auth()->user()->can('Efetuar-MATRICULA EXTERNOS')) {

            if ($request->tipopagamento == 2) {

                // $resultado = $this->pagamentovia($request->numero, $request->totalApagar);

                // dd($request->numero, $request->totalApagar);
                //  $resultDO =$this->MpesaService->sendPaymentRequest("matricula","258".$request->numero,(float)$request->totalApagar,"matricula");
                $resultDO = new mpesaController;
                $resul = $resultDO->Mpesapagamento('matricula', $request->numero, $request->totalApagar, $talaoNumero);

                if ($resul['INS'] != 'INS-0') {

                    return ['estado' => $resul['INS'], 'messagem' => $resul['Descricao']];
                }
                $Referenciadepagamento = $resul['Referencia'];
            }

            if (isset($request->Referencia)) {
                $Referenciadepagamento = $request->Referencia;

            }
            // encaregado

            // fim

            $nomesDoencas = $request->doencas; // se não existir, cria array vazio
            $array = [];
            if ($nomesDoencas[0] == null) {

                $nomesDoencas[0] = 'Sem doença';

            }
            $doencas = '';
            foreach ($nomesDoencas as $doenca) {
                Doenca::updateOrCreate(
                    ['nome' => $doenca]);
            }
            $doencas = json_encode(Doenca::whereIn('nome', $nomesDoencas)->pluck('id')->toArray());

            $edereco = endereco::updateOrCreate(
                ['Endereco' => $request->bairro, 'RuaAvenida' => $request->rua_avenida]
            );

            $encaregado = $this->fliacao($request->nome_encarregado, $request->profissao_encarregado, $request->sexo_encarregado);
            foreach ($request->contacto as $contacto) {

                if ($contacto != null) {
                    $dados = contacto::updateOrCreate(
                        ['Descricao' => $contacto, 'encaregado_id' => $encaregado],
                        ['Descricao' => $contacto, 'encaregado_id' => $encaregado]);

                }
            }
            //   dd($edereco,$doenca,$request->all());

            $estadoSaude = $request->estado_saude;

            $pais = '';

            $pais = Pais::where('nome', $request->pais)->first();
            $provincia = provincia::updateOrCreate(['nome' => $request->provincia, 'pais_id' => $pais?->id]);
            $naturalidade = distrito::updateOrcreate(['nome' => $request->naturalidade, 'provincia_id' => $provincia?->id]);

            $dadosAlunos = Aluno::updateOrCreate(
                [
                    'nome' => $request->nome_aluno,
                    'dataNascimento' => $request->data_nascimento,
                    'sexo' => $request->sexo_aluno,

                ],
                [
                    'pai_id' => $this->fliacao($request->nome_pai, $request->profissao_pai, 'M'),
                    'mae_id' => $this->fliacao($request->nome_mae, $request->profissao_mae, 'F'),
                    'doencaCronca' => $estadoSaude,
                    'doenca_id' => $doencas,
                    'religiae_id' => $request->religiao,
                    'user_id' => auth()->user()->id,
                    'encaredado_id' => $encaregado,
                    'grauParentesto_id' => $request->grau_parentesco,
                    'endereco_id' => $edereco?->id,
                    'Quarterao' => $request->quarteirao,
                    'Casa' => $request->casa_numero,
                    'provincia_id' => $provincia?->id,
                    'naturalidade_id' => $naturalidade?->id,
                    'pais_id' => $pais?->id,
                ]
            );

            // $aque

            // dd($request->idtipopagamento,$request->all());
            $this->guardaAvatar($dadosAlunos, $request);

            // matrucula
            $mentodoPagaento = DB::table('metodo_pagamento')->where('id', $request->tipopagamento)->first();

            $matricula = $this->matricular($dadosAlunos->id, $request->classe, $request->ano_lectivo, $Referenciadepagamento, $mentodoPagaento, $request->idtipopagamento, $request->multaActiva ?? 0, $talaoNumero);

            // dd($mentodoPagaento,$request->idtipopagamento);
            // registar pagamento
  $tipospagamento=$request->tipospagamento??[];

            $this->registar_pagamentos($matricula->id, $tipospagamento);
            // dd($request->all());
            $this->setpagamentos($matricula, $request->meses ?? null, $request->mesesMulta ?? null, $request->tipopagamento, $Referenciadepagamento, $talaoNumero);
            // adicionar pagamentos
            $idaluno = $matricula->id;
            $anolectivo = $matricula->anolectivo_id;
            if ($mentodoPagaento->tipo > 0) {
                // $idaluno = $matricula->id;
                // $anolectivo = $matricula->anolectivo_id;
                $requestDADOS = new Request;
                $requestDADOS->merge([
                    'Tiposaida' => 101,
                    'idAluno' => $idaluno]);
                //  dd($requestDADOS->all(),$mentodoPagaento->tipo);

                $this->saidaTran($requestDADOS);
            }

            return ['estado' => 'INS-0', 'messagem' => 'Matricula Realisada Com sucesso', 'idaluno' => $idaluno,
                'anolectivo' => $anolectivo, 'talao' => $talaoNumero, 'metodo' => $request->tipopagamento];
        } else {
            $mensagem = 'nao possue a permissao de Realizar Matricula';

            return ['estado' => 'INS-897', 'messagem' => $mensagem];
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ano)
    {


    $tipo1 = DB::table("tipos_pagamentos")->where("id", 1)->first();
$tipo2 = DB::table("tipos_pagamentos")->where("id", 2)->first();

$extrno = "Visualizar-" . trim($tipo1->Descricao ?? '');
$interno = "Visualizar-" . trim($tipo2->Descricao ?? '');


// debug opcional
// dd($extrno, $interno);

if (
    auth()->user()->can($extrno) ||
    auth()->user()->can($interno) ||
    auth()->user()->can('Ver-Aluno') ||
    auth()->user()->can('Modificar-Estado') ||
    auth()->user()->can('Editar-Aluno')
) {
    // código autorizado

            $alunosInscritos = $this->alunosInscritos;
            // dd($alunosInscritos );


            return view('registoAcademico.Alunos-inscritos', compact('alunosInscritos'));
        } else {
            $mensagem = 'nao possue a permisao de ver a lista dos alunos inscritos 4';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (auth()->user()->can('Efetuar-MATRICULA INTERNOS')) {

            $aluno = $this->alunosInscritos->where('id', $id)->first();

            $classeDescricao = $aluno->AlunoClasse->last();
            $class = $aluno->classefrequentada->last();
            $classesshow = '';
            $anolectivo = anolectivo::all()->last();
            if ($classeDescricao->Descricao == 'Aprovado') {

                $classesshow = $this->classes->where('id', '>', $class->id)->get();
            } else {
                $classesshow = $this->classes->where('id', '>=', $class->id)->get();
            }
            $metodos = DB::table('metodo_pagamento')->get();
            $tabelavaloresano = DB::table('tabelavaloresano')->get();

            return view('registoAcademico.Aluno-matricula-atualizar', compact('aluno', 'class', 'classeDescricao', 'classesshow', 'metodos', 'anolectivo', 'tabelavaloresano'));
        } else {
            $mensagem = 'nao possue a permisao de ver a lista dos alunos inscritos 3';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  $atualizacao de matricula
    public function gerarReferencia($id, $class, Request $request)
    {
        $ano = anolectivo::where('id', $request->anolectivo)->first();
        $mentodoPagaento = DB::table('metodo_pagamento')->where('Descricao', $request->tipopagamento)->first()->id;
        // dd( $mentodoPagaento);
        $valorPagar = '';
        if (auth()->user()->can('Atualizar-Matriculas')) {
            $valorPagar = DB::table('detalhestabelavaores')
                ->where('classe_id', $class)
                ->where('anolectivo_id', $ano->anolectivo)->where('tipo', 3)->first();

        }

        // dd($request->all(), $ano,$mentodoPagaento, $request->tipopagamento,$valorPagar);

    }

    //
    public function atrualizacaoMatricula($id, Request $request)
    {

        $ano = anolectivo::where('id', $request->anolectivo)->first();

        $Referenciadepafamento = null;

        $talaoNumero = $this->talao($request->tipopagamento, $request->anolectivo);

        if (auth()->user()->can('Efetuar-MATRICULA INTERNOS')) {

            //  dd( $request->all());

            $multa = $request->input('multaAct', 0);
            if ($multa == 'undefined') {
                $multa = 0;
            }

            $Referenciadepagamento = null;

            if (auth()->user()->can('Efetuar-MATRICULA INTERNOS')) {

                if ($request->tipopagamento == 2) {

                    //  $resultDO =$this->MpesaService->sendPaymentRequest("matricula","258".$request->numero,(float)$request->totalApagar,"matricula");
                    $resultDO = new mpesaController;
                    $resul = $resultDO->Mpesapagamento('matricula', $request->numero, $request->totalApagar, $talaoNumero);

                    if ($resul['INS'] != 'INS-0') {

                        return ['estado' => $resul['INS'], 'messagem' => $resul['Descricao']];
                    }
                    $Referenciadepagamento = $resul['Referencia'];
                }

                if (isset($request->Referencia)) {
                    $Referenciadepagamento = $request->Referencia;

                }

                $dadosAlunos = Aluno::where('id', $id)->first();

                // dd($dadosAlunos);

                $this->guardaAvatar($dadosAlunos, $request);

                // matrucula
                $mentodoPagaento = DB::table('metodo_pagamento')->where('id', $request->tipopagamento)->first();

                $matricula = $this->matricular($dadosAlunos->id, $request->ClassedeAtualizacao, $request->anolectivo, $Referenciadepagamento,
                    $mentodoPagaento, $request->idtipopagamento, $request->multaActiva ?? 0, $talaoNumero);
                    $tipospagamento=$request->tipospagamento??[];

                $this->registar_pagamentos($matricula->id, $tipospagamento);

                $this->setpagamentos($matricula, $request->meses ?? null, $request->mesesMulta ?? null, $request->tipopagamento, $Referenciadepagamento, $talaoNumero);

                // dd($dadosAlunos,$mentodoPagaento);
                $mes = meses::where('id', Carbon::now()->month)->first()->Descricao;
                $data = 'Quelimane   aos     ,'.Carbon::now()->day.'   de        '.$mes.'       de        '.Carbon::now()->year;

                // dados de valores
                $dadosMatriculaValores = DB::table('tabelavaloresano')->where('classId', $request->classe)
                    ->where('finalidade', 'Matriculas')->where('idanolectivo', $request->anolectivo)->get();

                // return $this->imprimir_reciboMatriculaInicial($matricula->aluno_id, $matricula->anolectivo_id);

                $idaluno = $matricula->id;
                $anolectivo = $matricula->anolectivo_id;



                return ['estado' => 'INS-0', 'messagem' => 'Matricula Realisada Com sucesso', 'idaluno' => $idaluno,
                    'anolectivo' => $anolectivo, 'talao' => $talaoNumero, 'metodo' => $request->tipopagamento];
            } else {
                $mensagem = 'nao possue a permissao de Realizar Matricula';

                return ['estado' => 'INS-897', 'messagem' => $mensagem];
            }

        } else {
            $mensagem = 'nao possue a permisao de atualizar dados do Aluno ';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }
    }

    public function update(Request $request, $id)
    {

        if (auth()->user()->can('Editar-Aluno')) {

            // fim

            $nomesDoencas = $request->doencas; // se não existir, cria array vazio
            $array = [];
            if ($nomesDoencas[0] == null) {

                $nomesDoencas[0] = 'Sem doença';

            }
            $doencas = '';
            foreach ($nomesDoencas as $doenca) {
                Doenca::updateOrCreate(
                    ['nome' => $doenca]);
            }
            $doencas = json_encode(Doenca::whereIn('nome', $nomesDoencas)->pluck('id')->toArray());

            $edereco = endereco::updateOrCreate(
                ['Endereco' => $request?->bairro, 'RuaAvenida' => $request?->rua_avenida]
            );

            $encaregado = $this->fliacao($request->nome_encarregado, $request->profissao_encarregado, $request->sexo_encarregado);
            foreach ($request->contacto as $contacto) {

                if ($contacto != null) {
                    $dados = contacto::updateOrCreate(
                        ['Descricao' => $contacto, 'encaregado_id' => $encaregado],
                        ['Descricao' => $contacto, 'encaregado_id' => $encaregado]);

                }
            }
            //   dd($edereco,$doenca,$request->all());

            $estadoSaude = $request->estado_saude;

            $pais = '';

            $pais = Pais::where('nome', $request->pais)->first();

            $provincia = provincia::updateOrCreate(['nome' => $request?->provincia, 'pais_id' => $pais?->id]);


            $naturalidade = distrito::updateOrcreate(['nome' => $request->naturalidade, 'provincia_id' => $provincia->id]);

            //   dd($request->all());
            $alunoid = alunoClasse::where('id', $id)->update(['classe_id' => $request->classe,
                'anolectivo_id' => $request->ano_lectivo]);

            // dd($alunoid);
            $alunoid = alunoClasse::where('id', $id)->first();

            $dadosAlunos = Aluno::where('id', $alunoid->aluno_id)->update([
                'dataNascimento' => $request->data_nascimento,
                'nome' => $request->nome_aluno,
                'doencaCronca' => $estadoSaude,
                'doenca_id' => $doencas,
                'religiae_id' => $request->religiao,
                'user_id' => auth()->user()->id,
                'sexo' => $request->sexo_aluno,
                'encaredado_id' => $encaregado,
                'grauParentesto_id' => $request->grau_parentesco,
                'endereco_id' => $edereco->id,
                'Quarterao' => $request->quarteirao,
                'Casa' => $request->casa_numero,
                'provincia_id' => $provincia->id,
                'naturalidade_id' => $naturalidade->id,
                'pai_id' => $this->fliacao($request->nome_pai, $request->profissao_pai, 'M'),
                'mae_id' => $this->fliacao($request->nome_mae, $request->profissao_mae, 'F'),
                'pais_id' => $pais?->id,
            ]);

            $aluno = Aluno::where('id', $alunoid->aluno_id)->first();

            // $aque

            // dd($request->idtipopagamento,$request->all());
            $this->guardaAvatar($aluno, $request);

            // dd($request->all(),$dadosAlunos);

            if (! empty($request->tipospagamento)) {
                $table = array_unique(DB::table('detalhestabelavaores')
                    ->where('anolectivo_id', $request->ano_lectivo)
                    ->where('classe_id', $request->classe)
                    ->whereIn('tipo', $request->tipospagamento)
                    ->pluck('id')->toArray());

                // dd(array_unique($table));

                $this->registar_pagamentos($alunoid->id, $table??[]);
            }

            return redirect()->route('aluno.index');

        } else {
            $mensagem = 'nao possue a permissao de Atualizar dados do aluno';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (auth()->user()->can('Apagar-Aluno')) {

            $alunoidClassfrequenta = Aluno::where('id', $id)->first()->AlunoClasse;

            foreach ($alunoidClassfrequenta as $alunoidClassfrequentaval) {
                $mensalidade = mensalidade::where('aluno_classe_id', $alunoidClassfrequentaval->id)->delete();
            }

            Aluno::where('id', $id)->delete();

            // observar que apagou dados do aluno
            $this->observador($id, 'Aluno', 'delete');

            return redirect()->Route('aluno.mostrar');
        } else {
            $mensagem = 'Não possui a permissão de apagar  Aluno';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }

    }

    public function photo()
    {

        return view('registoAcademico.capture-web');
    }

    public function matricular($aluno, $classe, $ano, $refe, $metodo, $tipoPagamento, $multa, $talo)
    {

        $table = DB::table('detalhestabelavaores')
            ->where('id', $tipoPagamento)
             ->where('anolectivo_id', $ano)
            ->where('classe_id', $classe)
            ->first();

    //  dd($table,$tipoPagamento,$ano,$classe,$ano,$multa,);

        $estado = 'activo';

        //   dd($metodo);
        if ($metodo->tipo > 0) {
            $estado = 'pendente';
        }
        // dd($estado);
        $multaActiva = 1;
        if ($multa == 0) {
            $multaActiva = 0;
        }

        //  dd($aluno, $classe, $ano, $refe, $metodo,$tipoPagamento, $multa);
        $dados = alunoClasse::updateOrCreate(
            ['aluno_id' => $aluno,
                'anolectivo_id' => $ano
                ],
            ['classe_id' => $classe,
                'tipo_Pagamento_id' => $table->id,
                'metodo_pagamento' => $metodo->id,
                'usuario_registou' => auth()->user()->id,
                'estado' => $estado,
                'referencia' => $refe,
                'multaActiva' => $multaActiva,
                'Multa' => (float) $multa,
                'Ntalao' => $talo,
            ]
        );

        // Registra mensalidades se necessário
        $dadosItem = DB::table('anolectivometadata')
            ->where('anolectivo_id', $ano)
            ->get();

        //  dd($metodo,$tipoPagamento,$ano,$classe,$ano);

        $this->observador($dados->id, 'Aluno', 'matricula');

        return $dados;

    }

    public function edititaer($id, $ano)
    {
  $contactos="";
        if (auth()->user()->can('Editar-Aluno')) {
            // $dados=$this->alunosInscritos->where('id',$id)->first();;
            $dados = DB::table('alunosescritos')->where('id', $id)
                ->where('anolectivo_id', $ano)
                ->first();


                $contactos=contacto::whereIn("encaregado_id",[ $dados->Encaregado_id,$dados->id_pai,$dados->id_mae])->get();
    //    dd( $dados,$contactos);
            $religiao = $this->religiao->all();
            $profissao = $this->profissao->all();
            $doencasCronicas = $this->doencas->all();
            $classes = $this->classes->all();
            $grauparentesco = $this->grauparentesco->all();
            $classeAluno = DB::table('aluno_classes')
                ->where('aluno_id', $id)
                ->where('anolectivo_id', $ano)
                ->first();
            $anolectivo = DB::table('anolectivos')->get();
            $tabelavaloresano = DB::table('tabelavaloresano')->get();
            $doenca = Doenca::all();

            $tipoPagamento = DB::table('outros_pagamentosview')
                ->where('aluno_classe_id', $id)
                ->select('tipo_pagamento_id')
                ->distinct()
                ->get();
            //  dd($tipoPagamento);

            return view('registoAcademico.matricular-atualizar-dados',
                compact('religiao', 'profissao', 'doencasCronicas', 'classes', 'grauparentesco', 'dados', 'classeAluno', 'anolectivo', 'ano', 'tabelavaloresano', 'doenca', 'tipoPagamento','contactos'));

        } else {
            $mensagem = 'nao possue a permissao de Atualizar dados do aluno';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }

    }

       public function visualizarAluno($id, $ano = null, $flag = null)
    {
        $dadosmatricula = collect();
        $request = Request();
        $host = $request->getHost();
// dd($id);
        $subdomain = explode('.', $host)[0];

        if (auth()->user()->can('Ver-Aluno')) {
            $aluno = DB::table('alunosescritos')->where('id', $id)->where('anolectivo_id', $ano)->first();
            $contactos=contacto::whereIn("encaregado_id",[ $aluno->Encaregado_id,$aluno->id_pai,$aluno->id_mae])->get();

            // dd($aluno);

            $contactos = DB::table('contactos')->where('encaregado_id', $aluno->Encaregado_id)->get();

            $dadosdedata =collect();
            //  collect(DB::select('CALL  formadepagamentos(?)', [$aluno->anolectivo]));
            // $tiposPagamento = $dadoMesalidades->pluck('tipoPagamento_id')->unique();
// dd($dadosdedata);
            $dados = DB::table('outros_pagamentosview')->where('aluno_classe_id', $aluno->idAlunoclasse)->get();
            $tiposPagamento = $dados->pluck('tipo_pagamento_id')->unique();

            // dd($aluno);

            $talao = $aluno->Ntalao;

            foreach ($tiposPagamento as $item) {
                $dadosmatricula->push([
                    'id' => $item,
                    'Descrica' => $dados
                        ->where('tipo_pagamento_id', $item)
                        ->pluck('tipodepagamentoDescricao')
                        ->unique()
                        ->first(), // pega a primeira descrição única
                    'parcelas' => $dados
                        ->where('tipo_pagamento_id', $item)
                        ->pluck('tipodepagamentoDescricao')
                        ->count(),
                    'pagasNodia' => $dados
                        ->where('tipo_pagamento_id', $item)
                        ->where('Ntalao', $aluno->Ntalao),

                ]);

                // aqui você pode salvar ou acumular $ em um array maior
            }
            $x = 0;
            $meses = $request->meses;
            $dadosMes = [];
            $dadadoitem =   $dados->
                where('Ntalao', $aluno->Ntalao);
            foreach ($dadadoitem as $item) {
                // dd($item->tipo_pagamento_id);
                // $item= (object)$item;
                $dadosMes[$x]['tipo'] = $item->tipo_pagamento_id;
                $dadosMes[$x]['mes'] = $item->mes_id;
                $x++;
            }

            // dd($dadosMes);
            $idaluno = $aluno;
            //          return ["estado"=>"INS-0","messagem"=>"Matricula Realisada Com sucesso",'idaluno' => $idaluno,
            //          'anolectivo' => $anolectivo,"meses"=>$dadosMes,"metodo"=>$request->tipopagamento];
            // //    dd($dadosmatricula,$dadosmatricula);

            return view('registoAcademico.Visualizar-dados-Recibo', compact('aluno', 'flag', 'dadosMes', 'idaluno',
                'dadosdedata', 'contactos', 'ano', 'subdomain', 'dadosmatricula','contactos'));
        } else {
            $mensagem = 'nao possue a permissao de  Ver dados do aluno';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }
    }


    public function visualizarAlunoCheio($id, $ano = null, $flag = null)
    {
        if (auth()->user()->can('Ver-Aluno')) {
            $aluno = DB::table('alunosescritos')->where('id', $id)->where('anolectivo_id', $ano)->first();

            $dadoMesalidades = DB::table('mensalidadesview')->where('id', $id)->where('anolectivo_id', $ano)->get();
            $contactos = DB::table('contactos')->where('encaregado_id', $aluno->Encaregado_id)->get();

            return view('registoAcademico.Visualizar-dados-Recibocheio', compact('aluno', 'flag', 'dadoMesalidades', 'contactos', 'ano'));
        } else {
            $mensagem = 'nao possue a permissao de  Ver dados do aluno';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }
    }

      public function Informacao($id)
    {
        // Buscar aluno


        $alunoclass=alunoClasse::where("id",$id)->first();

        $aluno = $this->alunosInscritos->where('id', $alunoclass->aluno_id)->firstOrFail();



        $classeDescricao = $aluno->AlunoClasse->last();
        $class = $aluno->classefrequentada->last();

        // Definir classes a mostrar conforme situação
        if ($classeDescricao->Descricao === 'Aprovado') {
            $classesshow = $this->classes->where('id', '>', $class->id)->get();
        } else {
            $classesshow = $this->classes->where('id', '>=', $class->id)->get();
        }

        // Outros dados do processo
        $processo_id = $aluno->id.'/'.now()->year;
        $data_abertura = now()->format('d/m/Y');
        $ano_lectivo = now()->year;
        $conf = DB::table('config')->first();

        // ⚠️ Corrigir: variável $observacoes não estava definida
        $observacoes = $aluno->observacoes ?? null;

        $dadosanteriores = DB::table('alunosescritos')->where('id', $id)->orderBy('idAlunoclasse', 'asc')->get();

        // Dados enviados à view
        $data = [
            'dadosAnterior' => $dadosanteriores,
            'aluno' => $aluno,
            'class' => $class,
            'classeDescricao' => $classeDescricao,
            'classesshow' => $classesshow,
            'observacoes' => $observacoes,
            'processo_id' => $processo_id,
            'data_abertura' => $data_abertura,
            'ano_lectivo' => $ano_lectivo,
            'conf' => $conf,
        ];

        // Renderizar a view como HTML

        $html = view('registoAcademico.imprimirInformacao', $data)->render();

        return $html;
        // Criar o PDF em A3 Landscape
        $css = file_get_contents(public_path('css/processsoIndivual.css'));
        $html2pdf = new Html2Pdf('L', 'A3', 'pt', true, 'UTF-8', [5, 5, 5, 5]);
        // $html2pdf->setTestTdInOnePage(false);
        $html2pdf->setTestIsImage(false);
        // $html2pdf->pdf->SetDisplayMode('fullpage');

        $css = file_get_contents(public_path('css/processsoIndivual.css'));
        $html2pdf->writeHTML('<style>'.$css.'</style>'.$html);

        // Nome do arquivo final
        $filename = 'processo_individual_'.Str::slug($aluno->nome).'_'.str_replace('/', '-', $processo_id).'.pdf';

        // 👉 Exibir no navegador (outra opção abaixo: salvar)
        return response($html2pdf->output($filename, 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "inline; filename=\"$filename\"");
    }
    public function fichaAluno($id)
    {
        // Buscar aluno
        $aluno = $this->alunosInscritos->where('id', $id)->firstOrFail();
        $classeDescricao = $aluno->AlunoClasse->last();
        $class = $aluno->classefrequentada->last();

        // Definir classes a mostrar conforme situação
        if ($classeDescricao->Descricao === 'Aprovado') {
            $classesshow = $this->classes->where('id', '>', $class->id)->get();
        } else {
            $classesshow = $this->classes->where('id', '>=', $class->id)->get();
        }

        // Outros dados do processo
        $processo_id = $aluno->id.'/'.now()->year;
        $data_abertura = now()->format('d/m/Y');
        $ano_lectivo = now()->year;
        $conf = DB::table('config')->first();

        // ⚠️ Corrigir: variável $observacoes não estava definida
        $observacoes = $aluno->observacoes ?? null;

        $dadosanteriores = DB::table('alunosescritos')->where('id', $id)->orderBy('idAlunoclasse', 'asc')->get();

        // Dados enviados à view
        $data = [
            'dadosAnterior' => $dadosanteriores,
            'aluno' => $aluno,
            'class' => $class,
            'classeDescricao' => $classeDescricao,
            'classesshow' => $classesshow,
            'observacoes' => $observacoes,
            'processo_id' => $processo_id,
            'data_abertura' => $data_abertura,
            'ano_lectivo' => $ano_lectivo,
            'conf' => $conf,
        ];

        // Renderizar a view como HTML

        $html = view('registoAcademico.Documentos.fichaAluno', $data)->render();

        return $html;
        // Criar o PDF em A3 Landscape
        $css = file_get_contents(public_path('css/processsoIndivual.css'));
        $html2pdf = new Html2Pdf('L', 'A3', 'pt', true, 'UTF-8', [5, 5, 5, 5]);
        // $html2pdf->setTestTdInOnePage(false);
        $html2pdf->setTestIsImage(false);
        // $html2pdf->pdf->SetDisplayMode('fullpage');

        $css = file_get_contents(public_path('css/processsoIndivual.css'));
        $html2pdf->writeHTML('<style>'.$css.'</style>'.$html);

        // Nome do arquivo final
        $filename = 'processo_individual_'.Str::slug($aluno->nome).'_'.str_replace('/', '-', $processo_id).'.pdf';

        // 👉 Exibir no navegador (outra opção abaixo: salvar)
        return response($html2pdf->output($filename, 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "inline; filename=\"$filename\"");
    }

    public function imprimir_reciboMatricula($anolectivo, $id, $talao,
    $metodoId, $flag = null)
    {
        // Buscar método de pagamento

$nomeDoc="Recibo";

        $metodo = DB::table('metodo_pagamento')->where('id', $metodoId)->first();
        $banco=DB::table("bancos")->where("id",$metodo->tipo)->first();

//  dd($metodo,$banco);
        // Buscar matrícula
        $matricula = DB::table('alunosescritos')
             ->where("anolectivo_id", $anolectivo)
            ->where('idAlunoclasse', $id)
            ->first();



        if (! $matricula) {
            abort(404, 'Matrícula não encontrada');
        }

        //  dd( $dadosJson,  $metodo,$metodoId,$flag);

        // Montar data formatada
        $mesDescricao = meses::where('id', Carbon::parse($matricula->datainscricao)->month)
            ->first()->Descricao ?? '';
        $data = 'Quelimane, '.Carbon::parse($matricula->datainscricao)->day.
            ' de '.$mesDescricao.' de '.Carbon::parse($matricula->datainscricao)->year;

        // Valores da matrícula
$dadosMatriculaValores = DB::table('detalhestabelavaores')
    ->where('classe_id', $matricula->Classe_id)
    ->where('id', $matricula->tipo_Pagamento_id)
    ->where('anolectivo_id', $anolectivo)
    ->first();

$dadosTabela = collect();
$dadosArray = collect();

// $array = DB::table('relatoriograficoview')
//     ->where('aluno_classe_id', $matricula->idAlunoclasse)
//     ->where('tipo_pagamento_id', '>', 2)
//     ->where('Ntalao', $talao)
//     ->get();

 $array=outros_pagamentos::where("aluno_classe_id", $matricula->idAlunoclasse)->where('Ntalao', $talao)
    ->get();

// dd( $array);
foreach ($array as $itemArray) {

    $dadosArray->push([
        'tipo' => $itemArray->tipo_pagamento_id,
        'mes' => $itemArray->mes_id
    ]);
}

       // dd($dadosArray);

        if (! empty($dadosArray)) {

            foreach ($dadosArray as $item) {
                //   dd($dadosArray);
                if (! isset($item['mes'], $item['tipo'])) {
                    continue;
                }

                // dd($dadosArray);

                $aluno = alunoClasse::find($matricula->idAlunoclasse);
                if (! $aluno) {
                    continue;
                }

                $dadosV = collect();
                $dadocolect = null;

                // Buscar detalhe do pagamento
                $detalhe = DB::table('detalhestabelavaores')
                    ->where('id', $item['tipo'])
                    ->where('anolectivo_id', $aluno->anolectivo_id)
                    ->where('mes', $item['mes'])
                    ->first();
                    // print_r($detalhe);

                if (! $detalhe) {
                    continue;
                }

// dd($metodo);
                if ($metodo->tipo == 1) {
                    $multaflag = Carbon::parse($detalhe->limite)->isPast() ? 1 : 0;
                    $dadocolect = DB::table('referenciasbancariasview')
    ->where('id', $matricula->idAlunoclasse)
    ->where('tipo_pagamento_id', $detalhe->id)
    ->where('mes_id', $detalhe->mes)
    ->where(function ($query) use ($multaflag) {
        $query->where('multaflag', $multaflag)
              ->orWhereNull('multaflag');
    })
    ->first();
    // dd($dadocolect, $matricula->idAlunoclasse);
   $nomeDoc = "Cotação";
   $outro=DB::table('outros_pagamentosview')
->where("aluno_classe_id", $matricula->idAlunoclasse)
->where("mes_id", $detalhe->mes)
->where("tipoPagamento_id",$detalhe->id)
->first();
  $nomeDoc = "Cotação";
//   dd($banco);

  if(empty($dadocolect)){
   $dadocolect = (object) [
                            'id' => $outro->id,
                            'nome' => $outro->nome,
                            'tipo' => $outro->tipo_pagamento_id,
                            'referencia' => "Por Gerar",
                            'limite' => $outro->limite,
                            'mes' => $outro->mes,
                            'classe_id' => $outro->classe_id,
                            'classe' => $outro->classe,
                          'tipo_pagamento_id' => $outro->tipoPagamento_id,
                            'tipo_pagamento' => $outro->tipoPagamento,
                            'valorDescricao' =>0,
                            'multa' => 0,
                            'Banco' =>  $banco->descricao ,
                            'Entidade' =>  $banco->Entidade,
                            'Banco_id' =>  $banco->id,
                            'anolectivo_id' => $outro->anolectivo_id,
                            'anolectivo' => $outro->nomeano,
                            'Estado' => $outro->Estado,
                            'Ntalao' => null,
                            'multaflag' => 0,

                        ];
  }

 if($outro->Estado=="Pago"||$outro->Estado=="activo"){
                    $nomeDoc = "Recibo";
                }



                } else {

                    $outro = DB::table('outros_pagamentosview')
                        ->where('id', $matricula->idAlunoclasse)
                        ->where('tipoPagamento_id', $detalhe->id)
                        ->where('mes_id', $detalhe->mes)
                        ->first();
  echo $dadocolect->tipo_pagamento??"null"."-".$detalhe->mes."-". $matricula->idAlunoclasse."-";
                       echo $detalhe->id."</br>";

                    if ($outro) {
                        $dadocolect = (object) [
                            'id' => $outro->id,
                            'nome' => $outro->nome,
                            'tipo' => $outro->tipo_pagamento_id,
                            'referencia' => $outro->referencia,
                            'limite' => $outro->limite,
                            'mes' => $outro->mes,
                            'classe_id' => $outro->classe_id,
                            'classe' => $outro->classe,
                            'tipo_pagamento_id' => $outro->tipoPagamento_id,
                            'tipo_pagamento' => $outro->tipoPagamento,
                            'valorDescricao' => $outro->valorDescricao + ($outro->Multa),
                            'multa' => $outro->multaP,
                            'Banco' => $outro->metodo_pagamento,
                            'Entidade' => $outro->metodo_pagamento,
                            'Banco_id' => $outro->metodo_pagamento_id,
                            'anolectivo_id' => $outro->anolectivo_id,
                            'anolectivo' => $outro->nomeano,
                            'Estado' => $outro->Estado,
                            'Ntalao' => $outro->Ntalao,
                            'multaflag' => 0,

                        ];
                    }
                }

                if ($dadocolect) {
                    $dadosV->push($dadocolect);

                    $tipo = optional($dadocolect)->tipo_pagamento ?? 'Tipo desconhecido';

                    if ($tipo !== 'Tipo desconhecido') {
                        $dadosTabela->push([
                            'Tipo' => $tipo,
                            'meses' => $dadosV,
                        ]);
                    }
                }
            }
        }

        // Garantir que não dê erro no Blade
        $primeiroItem = $dadosTabela->first();

        $primeiroMes = null;
        if ($primeiroItem && isset($primeiroItem['meses'])) {
            $primeiroMes = $primeiroItem['meses']->first() ?? null;
        }
        // $numero=DB::table("")
        $talao = $flag > 0 ? $talao : $matricula->Ntalao;
        // dd($anolectivo, $id, $dadosJson, $metodoId,$flag=null);

        // Gerar PDF

        $pdf = Pdf::loadView('registoAcademico.recibo-matricula-Remprimir', [
            'matricula' => $matricula,
            'data' => $data,
            'dadosMatriculaValores' => $dadosMatriculaValores,
            'dadosTabela' => $dadosTabela,
            'metodo' => $metodo,
            'primeiroMes' => $primeiroMes,
            'flag' => $flag,
            'talao' => $talao,
            "nomeDoc"=> $nomeDoc

        ]);

        $pdf->setPaper('A5', 'portrait');

        return $pdf->stream('recibo-matricula.pdf');
    }

    // apagar difinitivamente
    public function Reciclagem()
    {
        $alunosReciclagem = DB::table('alunos')->where('deleted_at', '<>', null)
            ->join('aluno_classes', 'aluno_classes.id', '=', 'alunos.id')
            ->join('classes', 'classes.id', '=', 'aluno_classes.classe_id')
            ->join('anolectivos', 'anolectivos.id', '=', 'aluno_classes.anolectivo_id')
            ->join('enderecos', 'enderecos.id', '=', 'alunos.endereco_id')
            ->join('encaregados', 'encaregados.id', '=', 'alunos.encaredado_id')
            ->join('grauparentestos', 'grauparentestos.id', '=', 'alunos.grauParentesto_id')
            ->get(['alunos.nome', 'alunos.dataNascimento as dataNascimento',
                'alunos.sexo',
                'alunos.id',
                'alunos.Tipo',
                'classes.Descricao as classe',
                'enderecos.Endereco',
                'anolectivos.anolectivo',
                'encaregados.nome as nomeencaregado',
                'grauparentestos.Descricao as encaregadoGrauparentesco',
                'enderecos.RuaAvenida']);

        // dd($alunosReciclagem);
        return view('registoAcademico.Alunos-reciclagem', compact('alunosReciclagem'));
    }

    public function apagarDifinitivo($id)
    {
        // remove
        // $ded=DB::table('')->get();

    }

    public function dadosAlunosAno($ano = null, $classe = null)
    {

   $tipo1 = DB::table("tipos_pagamentos")->where("id", 1)->first();
$tipo2 = DB::table("tipos_pagamentos")->where("id", 2)->first();

$extrno = "Visualizar-" . trim($tipo1->Descricao ?? '');
$interno = "Visualizar-" . trim($tipo2->Descricao ?? '');

// debug opcional
// dd($extrno, $interno);

if (
    auth()->user()->can($extrno) ||
    auth()->user()->can($interno) ||
    auth()->user()->can('Ver-Aluno') ||
    auth()->user()->can('Modificar-Estado') ||
    auth()->user()->can('Editar-Aluno')
) {
    // código autorizado


        $retornoAlunos = '';
        $mes = meses::all();
        if ($classe != null) {
            $retornoAlunos = DB::table('alunosescritos')
                ->where('anolectivo_id', $ano)
                ->where('classe_id', $classe)
                ->get();
        } else {
            $retornoAlunos = DB::table('alunosescritos')->where('anolectivo_id', $ano)->get();
        }
        $tipossaida = tipossaida::all();
        $classes = classe::all();


        return view('registoAcademico.Alunos-inscritos', compact('retornoAlunos', 'mes', 'tipossaida', 'classes'));
 }
 else {
            $mensagem = 'nao possue a permisao de ver a lista dos alunos inscritos 4';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }

    }

    public function ApagarDados($id, $ano)
    {
        if (auth()->user()->can('Apagar-Aluno')) {
            echo $ano;

            $aluno = json_encode(DB::table('alunos')->where('id', $id)->get());
            $alunosAnolectivo = DB::table('aluno_classes')->where('aluno_id', $id)->where('anolectivo_id', $ano)->first();
            $alunosMensalidade = DB::table('mensalidadesview')->where('id', $id)->where('anolectivo_id', $ano)->first();
            //
            // DB::insert('insert into Reciclagem (id, data_key,data_meta) values (?,?,?)', [$id,"dados_pessoais", $aluno]);
            // DB::insert('insert into Reciclagem (id, data_key,data_meta) values (?,?,?)', [$id,"anolectivo", json_encode([$alunosAnolectivo,$alunosMensalidade])]);

            // DB::delete('delete mensalidades where aluno_classe_id = ?', [$alunosAnolectivo->id]);
            // DB::table('mensalidades')->where('aluno_classe_id',$alunosAnolectivo->id)->delete();
            // DB::delete('delete aluno_classes where aluno_id = ? and anolectivo_id= ?', [$id,$ano]);
            // DB::table('aluno_classes')->where('aluno_id',$id)->where('anolectivo_id',$ano)->delete();
            $this->observador($alunosAnolectivo->id, 'Aluno', 'deleted');
            mensalidade::where('aluno_classe_id', $alunosAnolectivo->id)->delete();
            alunoClasse::where('aluno_id', $id)->where('anolectivo_id', $ano)->delete();

            $classe_aluno = DB::table('aluno_classes')->where('aluno_id', $id)->get();
            if (isset($classe_aluno[0]->aluno_id)) {
                echo 'ainda tem mais dados';
            } else {
                Aluno::where('id', $id)->delete();
            }

            return redirect()->Route('aluno.mostrar');
        } else {
            $mensagem = 'nao possue a permissao de  Apagar Aluno';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }

    }

    public function atualizacaoIndex($id = null, $dados = null, $ano = null, $metodo = null)
    {
        $alunoIds = DB::table('aluno_classes')
            ->whereNull('deleted_at')
            ->distinct()
            ->pluck('aluno_id')
            ->toArray();
        $anolectivo = Anolectivo::orderBy('id', 'desc')->get();
        $alunos = Aluno::whereIn('Id', $alunoIds)->get();
        $tabelavaloresano = DB::table('tabelavaloresano')->get();

        return view('registoAcademico.Atualizar-matricula-index',
            compact('alunos', 'anolectivo', 'dados', 'id', 'ano', 'metodo', 'tabelavaloresano'));

    }

    public function mensagemAlerta($mensagem)
    {

        return view('Componetes.alerta-Falha', compact('mensagem'));
    }

    public function observador($aluno, $modelo, $tipoOperacao)
    {
        // $tipoOperacao="create";
        // $modelo="Aluno";
        $usuario = auth()->user()->id;
        observadorSys::updateOrCreate(['user_id' => $usuario, 'action' => $tipoOperacao, 'register' => $aluno,
            'model' => $modelo], ['user_id' => $usuario, 'action' => $tipoOperacao, 'register' => $aluno, 'model' => $modelo]);

    }

    public function restoryAlunoClasse($class_aluno_id)
    {
        $aluno = alunoClasse::onlyTrashed()
            ->where('id', $class_aluno_id);
        $aluno->restore();

        return redirect()->Route('aluno.mostrar');
    }

    public function pagamentovia($valorPagar, $numero)
    {

        $mpesa = new modelmpesapay;
        $result = $mpesa->tranferencia($valorPagar, '258'.$numero);

        if ($result[0]->output_ResponseCode == 'INS-0') {
            return collect(['referencia' => $result[2]->output_TransactionID, 'alerta' => '1'])->first();

        } else {

            return collect(['referencia' => $result[2], 'alerta' => '0'])->first();
        }

    }

    public function Relatorio_matriculas()
    {
 if (auth()->user()->can("RelatorioPagameto-MATRICULA EXTERNOS")
                                    || auth()->user()->can("RelatorioPagameto-MATRICULA INTERNOS")){
        $ano = DB::select('SELECT  * from anolectivos  order by(id) desc');
        $classe = DB::select('SELECT  * from classes');
        $tipopagamento = DB::table('tipos_pagamentos')->where('id', '<', 3)->get();
        $data = Carbon::now()->format('m/d/').'20'.Carbon::now()->format('y');
        $tipo = tipos_pagamentos::where('id', '<', 3)->get();

        return view('registoAcademico.relatoriospagamentos.relatoriospagamentos.relatorio-Matricula-index', compact('classe',
            'ano', 'data', 'tipo', 'tipopagamento'));
                                    }
                                  else {
            $mensagem = 'nao possue a permissao  ver Relatorio';

            return view('Componetes.alerta-Falha', compact('mensagem'));
        }

    }
public function pagamentos($ano, $classe, $data1, $data2, $tipo)
{
    $inicio = Carbon::parse($data1, 'Africa/Maputo')->startOfDay();
    $fim = Carbon::parse($data2, 'Africa/Maputo')->endOfDay();

    $classeArray = ($classe == 0)
        ? classe::pluck('id')->toArray()
        : classe::where('id', $classe)->pluck('id')->toArray();

    $dados = collect();

    $pagamentos = detalhestabelavalores::where('tipo', $tipo)
        ->where('anolectivo_id', $ano)
        ->with([
            'matriculas' => function ($q) use ($inicio, $fim, $classeArray) {
                $q->where('estado', 'activo')
                  ->whereIn('classe_id', $classeArray)
                  ->whereNull('deleted_at')
                  ->with(['metodopagamento'])
                  ->whereBetween('updated_at', [$inicio, $fim]);
            }
        ])
        ->first();

    $pagamentos?->matriculas->each(function ($e) use ($dados, $pagamentos) {
        $dados->push((object)[
            "aluno_classe_id" => $e->id,
            'nome' => $e->aluno->nome,
            'classe_id' => $e->classe_id,
            'classe' => $e->classe->Descricao,
            'anolectivo_id' => $e->anolectivo->id,
            'anolectivo' => $e->anolectivo->anolectivo,
            'tipo_pagamento_id' => $pagamentos->tipo,
            'tipo_pagamento_descricao' => $pagamentos->Descricao,
            'valorDescricao' => $pagamentos->valorDescricao,
            'data_pagamento' => $e->data_pagamento,
            'data_Inicio' => $e->data_inicio,
            'data_limite' => $e->data_Fim,
            'Ntalao' => $e->Ntalao,
            'estado' => $e->estado,
            'Multa' => $e->Multa,
            'mes_id' => $e->mes()->id,
            'mes' => $e->mes()->Descricao,
            'referencia' => $e->referencia,
            'deleted_at' => $e->deleted_at,
            'metodo_pagamento' => $e->metodopagamento?->id,
            'metodoPagDesc' => $e->metodopagamento?->Descricao,
        ]);
    });

    // AGRUPAMENTO CORRETO (Collection)
    $esperadoDetalhes = $dados->groupBy('data_pagamento')->map(function ($items) {
        return (object)[
            'data_pagamento' => $items->first()->data_pagamento,
            'Classessize' => $items->pluck('classe_id')->unique()->count(),
            'ClassesList' => $items->pluck('classe')->unique()->implode(', ')
        ];
    });

    $outrosPagamentos = $dados;

    return view('registoAcademico.relatoriospagamentos.pagamentos-Matricula', compact(
        'esperadoDetalhes',
        'outrosPagamentos',
        'ano',
        'inicio',
        'fim',
        'tipo'
    ));
}

    public function pagamentosprint($ano, $classe, $data1, $data2, $tipo)
    {

        $inicio = Carbon::parse($data1, 'Africa/Maputo')->startOfDay();
        $fim = Carbon::parse($data2, 'Africa/Maputo')->endOfDay();
        $classeArray = '';
        if ($classe == 0) {
            $classeArray = classe::all()->pluck('id')->toArray();

        } else {
            $classeArray = classe::where('id', $classe)->pluck('id')->toArray();

        }

        // dd($ano, $classe, $data1, $data2,$tipo);
        $data = Carbon::create($data1)->format('Y-m-d');

        $periodo = CarbonPeriod::create($data1, $data2);
        $classessizeS = 1;

        $inicio = Carbon::parse($data1, 'Africa/Maputo')->startOfDay();
        $fim = Carbon::parse($data2, 'Africa/Maputo')->endOfDay();
        $classeArray = '';
        if ($classe == 0) {
            $classeArray = classe::all()->pluck('id')->toArray();

        } else {
            $classeArray = classe::where('id', $classe)->pluck('id')->toArray();

        }

        $esperadoDetalhes = DB::table('relatoriograficoview')
            ->where('tipo_pagamento_id', $tipo)
            ->whereIn('classe_id', $classeArray)
            ->where('anolectivo_id', $ano)
            ->whereBetween('data_pagamento', [$inicio, $fim])
            ->select('data_pagamento',
                DB::raw('COUNT(DISTINCT classe_id) as Classessize'),
                DB::raw("GROUP_CONCAT(DISTINCT classe ORDER BY classe SEPARATOR ', ') as ClassesList")

            )->groupBy(['data_pagamento'])
            ->get();

        $dados = DB::table('relatoriograficoview')
            ->where('tipo_pagamento_id', $tipo)
            ->whereIn('classe_id', $classeArray)
            ->where('anolectivo_id', $ano)
            ->whereBetween('data_pagamento', [$inicio, $fim])->get();

        // $tipo=tipos_pagamentos::where("id",$tipo)->get();

        return view('registoAcademico.relatoriospagamentos.pagamentosPrint_Matricula',
            compact('esperadoDetalhes', 'periodo', 'tipo', 'ano', 'data1', 'data2'));

    }

    // baixarplanilhas

    public function planilhaCadastro($ano)
    {


      return Excel::download(
        new ModeloImportacaoPagamentos($ano),
        'Modelo_Importacao_Pagamentos.xlsx'
    );
        // return response()->download(storage_path().'/app/fileDanlowad/planilhapararegistaralunos.xlsx');
    }

    public function uplodefileCadastrofile(Request $request,$ano)
    {

        $dadosrelatorio = Excel::toCollection(new alunosImport($ano), $request->file('file'));




       $dados= $this->excelCollectImport($dadosrelatorio->first(),$ano);
    //    dd($dadosrelatorio);

  $anolectivo =anolectivo::where("id",$ano)->first();
                $tipos = DB::table("detalhestabelavaores")->where("anolectivo_id", $anolectivo->id)

                ->where("tipo",">",2)->pluck('Descricao')->unique() ->toArray();

                $metodos = DB::table("metodo_pagamento")->pluck('Descricao')->toArray();
                $classes = DB::table("classes")->pluck('Descricao')->toArray();
                $paises = DB::table("paises")->pluck('nome')->toArray();
                $provincias = DB::table("provincias")->pluck('nome')->toArray();
                $distritos = DB::table("distritos")->pluck('nome')->toArray();
                $religioes = DB::table("religiaes")->pluck('nome')->toArray();
                $doencas = DB::table("doencas")->pluck('nome')->toArray();
                $graus = DB::table("grauparentestos")->pluck('Descricao')->toArray();
                $profissoes = DB::table("profissaos")->pluck('Descricao')->toArray();
        // $dados = request()->cookie('minha_colecao_cookie');
          return view("registoAcademico.alunos-inscrito-upload",["cabecalho"=>$dados["cabecalho"],
          "dados"=>$dados["dados"],
          "classe"=>$classes,
          "metodos"=>$metodos,
          "religioes"=>$religioes,
          "distritos"=>$distritos,
          "provincias"=>$provincias,
          "paises"=>$paises,
          "tipo"=>$tipos,
          "doencas"=>$doencas,
          "profissoes"=>$profissoes,
          "graus"=>$graus,
          "ano"=>$ano

          ]
        );

        // dd($dados);
     return json_encode($dados);

    }

    public function selecionar_tabelaValores(Request $request, $classe, $ano, $tipo)
    {

    // dd($request->pagamentos);
    $pagamentos = is_array($request->pagamentos) ? $request->pagamentos : [];
        $anos = anolectivo::find($ano);
        $dadosano = DB::table('detalhestabelavaores')
            ->where('classe_id', $classe)
            ->where('anolectivo_id', $ano)
            ->whereIn('tipo', $pagamentos)
            ->where('tipo', '>', 2)->get();

        $tabela_valores = DB::table('detalhestabelavaores')
            ->where('classe_id', $classe)
            ->where('anolectivo_id', $ano)
            ->where('tipo', $tipo)
            ->first();

        // dd($request->all(),$dadosano);

        $diasdeatraso = 0;
        $multa = 0;
        $mensagem = 'Não foi configurado para este tipo de pagamento no ano '.($anos->anolectivo ?? '');

        // Só define a mensagem vazia e calcula multa se tabela_valores existir
        if (! empty($tabela_valores)) {
            $mensagem = '';
            // calcula dias de atraso e multa se a data limite passou
            if (Carbon::now()->gt(Carbon::create($tabela_valores->limite))) {
                $diasdeatraso = Carbon::now()->diffInDays(Carbon::create($tabela_valores->limite));
                $multa = ($tabela_valores->valorDescricao * ($tabela_valores->multa / 100));
            }
        }

        $metodosdepagamento = DB::table('metodo_pagamento')->get();

        //  dd( $metodosdepagamento);

        return view('registoAcademico.matriculas-pagar', [
            'dados' => $tabela_valores, // talvez usar tabela_valores aqui?
            'multa' => $multa,
            'diasdeatraso' => $diasdeatraso,
            'metodosdepagamento' => $metodosdepagamento,
            'tabela_valores' => $tabela_valores,
            'mensagem' => $mensagem,
            'dadosano' => $dadosano,
        ]);
    }

    public function registar_pagamentos(int $alunoId, array $pagamentos)
    {
        DB::transaction(function () use ($alunoId, $pagamentos) {
            $aluno = alunoClasse::findOrFail($alunoId);

            $tabelaValores = DB::table('detalhestabelavaores')
                ->where('tipo', '>', 2)
                ->where('classe_id', $aluno->classe_id)
                ->where('anolectivo_id', $aluno->anolectivo_id)
                ->whereIn('id', $pagamentos)
                ->get();

                //  dd($tabelaValores, $pagamentos,$alunoId,);
            foreach ($tabelaValores as $item) {
                outros_pagamentos::updateOrCreate(
                    [
                        'aluno_classe_id' => $aluno->id,
                        'mes_id' => $item->mes,
                        'tipo_pagamento_id' => $item->id,
                    ],
                    [
                        'data_inicio' => $item->inicio,
                        'data_Fim' => $item->limite,
                        'deleted_at' => null,
                    ]
                );
            }

            outros_pagamentos::where('aluno_classe_id', $aluno->id)
                ->whereNotIn('tipo_pagamento_id', $tabelaValores->pluck('id')->toArray())
                ->where('Estado', '!=', 'Pago')
                ->delete();
        });
    }

    // registar os pagamentos efetuados
    public function setpagamentos($aluno, $meses, $mesesMulta, $metodopagamento, $referencia, $talao)
    {

        $dadosMulta = collect();

        if ($mesesMulta != null) {
            $dadosMulta = collect(array_map(fn ($v) => json_decode($v, true), $mesesMulta));
        }

        if ($meses != null) {

            foreach ($meses as $item) {
                $dado = json_decode($item);

                $tabelavalores = DB::table('detalhestabelavaores')
                    ->where('classe_id', $aluno->classe_id)
                    ->where('anolectivo_id', $aluno->anolectivo_id)
                    ->where('id', $dado->tipo)
                    ->where('mes', $dado->mes)
                    ->first();
                // dd($tabelavalores);
                $dadosM = $dadosMulta->where('tipo', $dado->tipo)->where('mes', $dado->mes)->first()['valor'] ?? 0;
                $multaActiva = $dadosM != 0 ? 1 : 0;
                $dadosmetodopagamento = DB::table('metodo_pagamento')
                    ->where('id', $metodopagamento)->first();
                $mesnome = meses::where('id', $dado->mes)->first();

                $mesedado = $multaActiva == 0 ? $mesnome : $mesnome->Descricao.' com Multa';
                if ($dadosmetodopagamento->tipo == 0) {
                    $saidadedado = outros_pagamentos::where('tipo_pagamento_id',
                        $dado->tipo)
                        ->where('aluno_classe_id', $aluno->id)
                        ->where('mes_id', $dado->mes)
                        ->update([
          'Ntalao' => $talao,
          'Estado' => 'Pago',
          'multaActiva' => $multaActiva,
          'Multa' => $dadosM,
          'metodo_pagamento_id' => $dadosmetodopagamento->id,
          'referencia' => $referencia,
          'usuario_Registou' => auth()->user()->id,
          'data_pagamento' => Carbon::now(),

      ]);
                } else {
                    $saidadedado = outros_pagamentos::where('tipo_pagamento_id',
                        $dado->tipo)
                        ->where('aluno_classe_id', $aluno->id)
                        ->where('mes_id', $dado->mes)
                        ->update([
                                           'Ntalao' => $talao,
                                           'multaActiva' => $multaActiva,
                                           'Multa' => $dadosM,
                                           'metodo_pagamento_id' => $dadosmetodopagamento->id,
                                           'referencia' => $referencia,
                                           'usuario_Registou' => auth()->user()->id,
                                           'data_pagamento' => Carbon::now(),

                                       ]);

                }

                $this->observador($aluno->id, $tabelavalores->Descricao, $mesedado);

            }

        }

    }

    public function guardaAvatar($dadosAlunos, $request)
    {

        //  dd($request->all(), $request->file('avatar-file'),($dadosAlunos));

        if (! $dadosAlunos) {
            return false;
        }

        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        $pasta = $subdomain.'/fotoAluno';
        $disk = 'public';

        $nomeArquivo = null;

        try {
            /**
             * 1️⃣ FOTO VIA UPLOAD
             */
            if ($request->hasFile('avatar-file') && $request->file('avatar-file')->isValid()) {
                $ext = $request->file('avatar-file')->extension();
                $nomeArquivo = $dadosAlunos->id.'.'.$ext;

                $request->file('avatar-file')->storeAs($pasta, $nomeArquivo, $disk);
            }

            /**
             * 2️⃣ FOTO VIA CÂMERA (BASE64)
             */
            elseif ($request->filled('image') && ! $request->hasFile('image')) {
                $imagemBase64 = $request->input('image');
                $imagemBase64 = preg_replace('/^data:image\/\w+;base64,/', '', $imagemBase64);

                $imagemBase64 = base64_decode($imagemBase64);
                $nomeArquivo = $dadosAlunos->id.'.jpg';

// dd($imagemBase64);
                Storage::disk($disk)->put($pasta.'/'.$nomeArquivo, $imagemBase64);
            }

            /**
             * 3️⃣ FOTO VIA UPLOAD (CAMPO "image")
             */
            elseif ($request->hasFile('image') && $request->file('image')->isValid()) {
                $ext = $request->file('image')->extension();
                $nomeArquivo = $dadosAlunos->id.'.'.$ext;

                $request->file('image')->storeAs($pasta, $nomeArquivo, $disk);
            } else {
                return false;
            }

            // Atualiza no banco
            $dadosAlunos->update([
                'avatar' => $nomeArquivo,
            ]);

            return true;
        } catch (\Exception $e) {
            // Loga o erro para debug
            \Log::error('Erro ao guardar avatar: '.$e->getMessage());

            return false;
        }
    }
    public function fliacao($nome, $profisao, $sexo)
    {

        $profissao = new profissaoController;

        $propfisaoid = $profissao->store($profisao ?? 'por confimar');

        $encaregdo = encaregado::Create(
            ['nome' => $nome ?? 'por Confirmar',
                'profissao_id' => $propfisaoid->id,
                'sexo' => $sexo ?? 'por confimar',
            ]

        );

        return $encaregdo->id;
    }

    public function validarReferencia($referencia)
    {
        $referencias = collect(DB::select('SELECT referencia COLLATE utf8mb4_general_ci AS referencia FROM outros_pagamentos UNION SELECT referencia COLLATE utf8mb4_general_ci AS referencia FROM aluno_classes'));

        $resultado = '';
        $dados = $referencias->where('referencia', $referencia)->first();
        // dd($dados==null);
        if ($dados == null) {
            $resultado = 'valido';

            // dd($referencia);

        } else {

            // invalido
            $resultado = 'invalido';

        }

        return ['status' => $resultado];
    }



    public function talao($metodo, $ano)
{
    /*
    |--------------------------------------------------------------------------
    | METODO PAGAMENTO
    |--------------------------------------------------------------------------
    */

    $metodoPagamento = DB::table('metodo_pagamento')
        ->select('id', 'tipo')
        ->where('id', $metodo)
        ->first();

    $anoRe = Carbon::now()->format('y');

    /*
    |--------------------------------------------------------------------------
    | CASO 1
    |--------------------------------------------------------------------------
    */

    if ($metodoPagamento->tipo <= 0) {

        $ultimoNtalao = alunoClasse::where('Estado', 'Pendente')
            ->whereNotNull('Ntalao')
            ->where('anolectivo_id', $ano)
            ->max('Ntalao');

    } else {

        /*
        |--------------------------------------------------------------------------
        | CASO 2
        |--------------------------------------------------------------------------
        */

        $ntalao1 = outros_pagamentos::where('Estado', 'Pago')
            ->whereNotNull('Ntalao')
            ->where('anolectivo_id', $ano)
            ->max('Ntalao');

        $ntalao2 = alunoClasse::where('Estado', 'activo')
            ->whereNotNull('Ntalao')
            ->where('anolectivo_id', $ano)
            ->max('Ntalao');

        $ultimoNtalao = max($ntalao1 ?? 0, $ntalao2 ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | EXTRAIR NUMERO
    |--------------------------------------------------------------------------
    */

    $sequencia = 0;

    if ($ultimoNtalao) {

        // remove os 2 primeiros dígitos do ano
        $sequencia = (int) substr($ultimoNtalao, 2);
    }

    /*
    |--------------------------------------------------------------------------
    | NOVO TALAO
    |--------------------------------------------------------------------------
    */

    $novoNumero = $sequencia + 1;

    // 260001
    $ntalao = $anoRe . str_pad($novoNumero, 4, '0', STR_PAD_LEFT);

    return $ntalao;
}



    // tranformarEcel e, collect

    public function excelCollectImport($collection,$ano){


     // Obtém tipos de pagamento únicos do ano lectivo
        $this->tipopagamento = DB::table("detalhestabelavaores")
            ->where("anolectivo_id", $ano)
            ->where("tipo", ">", 2)
            ->pluck('Descricao')
            ->unique()
            ->toArray();
         $dados = collect();

        // Começa a processar a partir da linha 8 (0-indexed)
        for ($x = 8; $x < $collection->count(); $x++) {
            $linha = $collection[$x];


            // --- 1. Verifica se a linha tem pelo menos 8 colunas ---
            if (!is_array($linha) && !($linha instanceof \ArrayAccess)) {
                continue; // ignora linhas inválidas
            }

            $colunasObrigatorias = array_slice($linha->toArray(), 0, 8);
            // dd($colunasObrigatorias);
            if (in_array(null, $colunasObrigatorias, true) || in_array('', $colunasObrigatorias, true)) {
                continue; // pula linhas incompletas
            }

            // --- 2. Sexo ---
            $sexoRaw = strtolower(trim($linha[2] ?? ''));
            $sexo = match($sexoRaw) {
                'masculino' => 'M',
                'feminino' => 'F',
                default => 'M',
            };

            // --- 3. Data de nascimento ---
            $dataNascimento = null;
            if (isset($linha[3]) && $linha[3] !== '') {
                try {
                    $dataNascimento = Date::excelToDateTimeObject($linha[3])->format('Y-m-d');
                } catch (\Exception $e) {
                    $dataNascimento = null;
                }
            }

            // --- 4. Tipo de pagamento ---
            $descricaoPagamento = trim($linha[5] ?? '');
            $tipopagamentoDB = DB::table("metodo_pagamento")
                ->where("Descricao", $descricaoPagamento)
                ->first();
            $tipopagamentoDesc = $tipopagamentoDB->Descricao ?? '';

            // --- 5. Colunas de pagamento ---
            $celunasPagamento = [];
            for ($i = self::COLUNAS_FIXAS; $i < self::COLUNAS_FIXAS + count($this->tipopagamento); $i++) {
                $celunasPagamento[$i] = $linha[$i] ?? null;
            }

            // --- 6. Monta linha final ---
            $linhaFinal = [
                ($x - 7),                   // posição
                trim($linha[1] ?? ''),      // nome aluno
                $sexo,                      // sexo
                $dataNascimento,            // data nascimento
                $linha[4] ?? '',            // classe
                $tipopagamentoDesc,         // tipo pagamento
                $linha[6] ?? '',            // multa matrícula
            ];

            // Adiciona colunas de pagamento
            $linhaFinal = array_merge($linhaFinal, $celunasPagamento);

            // Adiciona colunas extras restantes, se houver
            $restantes = array_slice($linha->toArray(), self::COLUNAS_FIXAS + count($this->tipopagamento));
            $linhaFinal = array_merge($linhaFinal, $restantes);

            // Adiciona linha processada à coleção final
            $dados->push($linhaFinal);
        }

        // Retorna dados processados e cabeçalho
        return [
            "dados" => $dados,
            "cabecalho" => $collection[7] ?? []
        ];


    }


public function MatriculaFila(Request $DADOSeXCEL)

{
    // dd($DADOSeXCEL->all());



    $talaoNumero = $this->talao(1, $DADOSeXCEL->ano);

    $tipos = DB::table("detalhestabelavaores")
        ->where("anolectivo_id", $DADOSeXCEL->ano)
        ->where("tipo", ">", 2)
        ->pluck('Descricao')
        ->unique()
        ->toArray();






    $TIPOS_SIZE = count($tipos);
    $anolectivo=anolectivo::where("id",$DADOSeXCEL->ano)->first()->anolectivo;
$sizepagamentoFolha= (count($DADOSeXCEL->cabecalho)-28);


	// dd($TIPOS_SIZE,$DADOSeXCEL->ano);
    if( ($TIPOS_SIZE)!=$sizepagamentoFolha){


        return ["status"=>"error","mensagem"=>"uma incompatiblidadoe do ano selecionado e a folha certifique se baxaste a folha do ano  $anolectivo esta folha possui  $sizepagamentoFolha tipos Pagamento e o ano    $TIPOS_SIZE"];
    }


    foreach ($DADOSeXCEL->dados as $linha) {

     $classe=classe::where("Descricao", $linha[4])->first();

     $matriculaid = DB::table("detalhestabelavaores")
        ->where("anolectivo_id", $DADOSeXCEL->ano)
        ->where("classe_id", $classe->id)
        ->where("tipo", 1)->first();

        if (!auth()->user()->can('Efetuar-matricula')) {
            continue;
        }

        $multa = ($linha[6] ?? '') === "Sim" ? 1 : 0;
        $Referenciadepagamento = null;
        if($multa>0){
            $multa=((($matriculaid->multa??0)/100)*($matriculaid->valorDescricao));
        }




        /*
        |--------------------------------------------------------------------------
        | DOENÇAS
        |--------------------------------------------------------------------------
        */
        $nomeDoenca = $linha[16 + $TIPOS_SIZE] ?? 'Sem doença';

        $doencaModel = Doenca::updateOrCreate(
            ['nome' => $nomeDoenca]
        );

        $doencas = json_encode([$doencaModel->id]);

        /*
        |--------------------------------------------------------------------------
        | ENDEREÇO
        |--------------------------------------------------------------------------
        */
        $edereco = Endereco::updateOrCreate(
            [
                'Endereco' => $linha[8 + $TIPOS_SIZE] ?? null,
                'RuaAvenida' => $linha[9 + $TIPOS_SIZE] ?? null
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ENCARREGADO
        |--------------------------------------------------------------------------
        */

        $encarregado = $this->fliacao(
            $linha[21 + $TIPOS_SIZE] ?? null,
            $linha[24 + $TIPOS_SIZE] ?? null,
            $linha[22 + $TIPOS_SIZE] ?? "M"
        );



        /*
        |--------------------------------------------------------------------------
        | CONTACTOS
        |--------------------------------------------------------------------------
        */
        $CONTACTOS = [
            $linha[25 + $TIPOS_SIZE] ?? null,
            $linha[26 + $TIPOS_SIZE] ?? null,
            $linha[27 + $TIPOS_SIZE] ?? null
        ];


        foreach ($CONTACTOS as $contacto) {
            if ($contacto) {
                Contacto::updateOrCreate(
                    ['Descricao' => $contacto],
                    ['encaregado_id' => $encarregado]
                );
            }

        }

        /*
        |--------------------------------------------------------------------------
        | LOCALIZAÇÃO
        |--------------------------------------------------------------------------
        */

     $pais = Pais::where(
    'nome',$linha[14 + $TIPOS_SIZE] ??"Por definir"
)->first();


        $provincia = Provincia::updateOrCreate(
            ['nome' => $linha[13 + $TIPOS_SIZE] ??"Por definir"],
            ['pais_id' => $pais?->id]
        );

        $naturalidade = Distrito::updateOrCreate(
            ['nome' => $linha[12 + $TIPOS_SIZE] ??"Por definir"],
            ['provincia_id' => $provincia?->id]
        );


        /*
        |--------------------------------------------------------------------------
        | ALUNO
        |--------------------------------------------------------------------------
        */
        // dd($naturalidade ,$linha[7 + $TIPOS_SIZE]);

$relig=$linha[7+ $TIPOS_SIZE] ?? "Por definir";
        $religiao=religiao::firstOrCreate(["nome"=>$relig]);
		$indexs=11+$TIPOS_SIZE;
        // dd( "casa=", $linha[$indexs],$indexs);



         $arrydata=explode("/",$linha[3]);
        //  dd($arrydata);
         $datanacimento=$arrydata[2]."-".$arrydata[1]."-".$arrydata[0];
        //  dd( $datanacimento);
     $data=carbon::parse($datanacimento);


        $aluno = Aluno::updateOrCreate(
            [
                'nome' => $linha[1],
                'dataNascimento' =>$data,
                'sexo' => $linha[2],
            ],
            [
                'pai_id' => $this->fliacao($linha[17 + $TIPOS_SIZE] ?? null, $linha[18 + $TIPOS_SIZE] ?? null, 'M'),
                'mae_id' => $this->fliacao($linha[19 + $TIPOS_SIZE] ?? null, $linha[20 + $TIPOS_SIZE] ?? null, 'F'),
                'doencaCronca' => $linha[15 + $TIPOS_SIZE] ??'nao',
                'doenca_id' => $doencas,
                'religiae_id' =>   $religiao->id,
                'user_id' => auth()->id(),
                'encaredado_id' => $encarregado,
                'grauParentesto_id' => $linha[23 + $TIPOS_SIZE] ?? null,
                'endereco_id' => $edereco->id ?? null,
                'Quarterao' => $linha[10 + $TIPOS_SIZE] ?? null,
                'Casa' => $linha[11 + $TIPOS_SIZE] ?? null,
                'provincia_id' => $provincia->id ?? null,
                'naturalidade_id' => $naturalidade->id?? null,
                'pais_id' => $pais?->id ?? null,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | MATRÍCULA
        |--------------------------------------------------------------------------
        */
        $metodoPagamento = DB::table('metodo_pagamento')
            ->where('Descricao', $linha[5])
            ->first();




        $matricula = $this->matricular(
            $aluno->id,
             $classe->id,
            $DADOSeXCEL->ano,
            $Referenciadepagamento,
            $metodoPagamento,
            $matriculaid->id,
            $multa,
            $talaoNumero
        );
        // dd($aluno ,$matricula);

        /*
        |--------------------------------------------------------------------------
        | PAGAMENTOS DINÂMICOS
        |--------------------------------------------------------------------------
        */

        $tipoPagamento=[];
        for ($x = 7; $x < (7 + $TIPOS_SIZE); $x++) {

            $descricaoTipo = $DADOSeXCEL->cabecalho[$x];
            $valor = $linha[$x] ?? "nao";
// echo  $descricaoTipo."". $valor."\n";
            if ($valor=="Sim") {


            $tabela=DB::table("detalhestabelavaores")
            ->where("Descricao",$descricaoTipo)
            ->where("anolectivo_id",$DADOSeXCEL->ano)
            ->where("classe_id",$classe->id)->first();

array_push($tipoPagamento,$tabela->id);


            }
        }
        // dd($tipoPagamento);

         $this->registar_pagamentos($matricula->id,$tipoPagamento);


    }

    return response()->json([
        'status' => true,
        'message' => 'Gravado com sucesso'
    ]);
}



}

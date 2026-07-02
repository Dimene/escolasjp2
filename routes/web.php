<?php

use App\Http\Controllers\Admin\aclController;
use App\Http\Controllers\Admin\configuracoesController;
use App\Http\Controllers\Admin\usuario\usuarioController;
use App\Http\Controllers\bancosControler;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\refrenciacController;
use App\Http\Controllers\registoAcademico\alunosController;
use App\Http\Controllers\registoAcademico\anoController;
use App\Http\Controllers\registoAcademico\classeController;
use App\Http\Controllers\registoAcademico\efetuarPagamentoController;
use App\Http\Controllers\registoAcademico\MensalidadesController;
use App\Http\Controllers\registoAcademico\mpesaController;
use App\Http\Controllers\registoAcademico\notascontroller;
use App\Http\Controllers\registoAcademico\outrospagamentoController;
use App\Http\Controllers\registoAcademico\tabelavaloresController;
use App\Http\Controllers\registoAcademico\tipos_pagamentoController;
use App\Http\Controllers\registoAcademico\turmasController;
use App\Http\Controllers\smsNotificacaoController;
use App\Models\registoAcademico\Aluno;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\mensalidade;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['tenant'])->group(function () {
Route::group(['middleware' => 'auth', 'prefix' => 'aluno'], function () {
    Route::resource('aluno', alunosController::class);
    Route::get('/mostrar', [alunosController::class, 'index'])->name('aluno.mostrar');

    Route::get('/planilhaCadastro/excel/{ano}', [alunosController::class, 'planilhaCadastro'])->name('aluno.planilhaCadastro');

     Route::post('/uplodefilemensalidades/excel/{anolectivo}', [MensalidadesController::class, 'uplodefileMensalidades'])->name('mensalidade.uplodefileCadastrofile');



 Route::post('/uplodefileCadastrofile/excel/{ano}', [alunosController::class, 'uplodefileCadastrofile'])->name('aluno.uplodefileCadastrofile');


    Route::get('/saida', [alunosController::class, 'saidaTran'])->name('aluno.saidaTran');
    Route::get('/mostrar/ano/{ano?}/{classe?}', [alunosController::class, 'dadosAlunosAno'])->name('aluno.dadosAlunosAno');
    Route::get('/Reciclagem', [alunosController::class, 'Reciclagem'])->name('aluno.Reciclagem');
    Route::get('/apagarDifinitivo/{id}', [alunosController::class, 'apagarDifinitivo'])->name('aluno.apagarDifinitivo');
    Route::get('/matricula', [alunosController::class, 'create'])->name('aluno.matricula');
    Route::get('/matricula/atualizar/{id}', [alunosController::class, 'edit'])->name('aluno.edit');
    Route::get('/Informacao/{id}', [alunosController::class, 'Informacao'])->name('aluno.Informacao');
    Route::get('/fichaAluno/{id}', [alunosController::class, 'fichaAluno'])->name('aluno.ficha');
    Route::get('/visualizar/{id}/{ano?}/{flag?}', [alunosController::class, 'visualizarAluno'])->name('aluno.visualizarAluno');
    Route::Post('/upload/fila/Matricula', [alunosController::class, 'MatriculaFila'])->name('aluno.MatriculaFila');
    Route::delete('/apagar/{id}', [alunosController::class, 'destroy'])->name('aluno.destroy');

    Route::PUT('/matricula/atualizarM/{id}', [alunosController::class, 'atrualizacaoMatricula'])
        ->name('aluno.atrualizacaoMatricula');

        // validar todas referencia nao repetir

    Route::get('/matricula/validarReferencia/{referencia}', [alunosController::class, 'validarReferencia'])
        ->name('aluno.validarReferencia');

        Route::get('/matricula/gerarReferencia/{id}/{class}', [alunosController::class, 'gerarReferencia'])
        ->name('aluno.gerarReferencia');
    Route::get(
        '/matricula/atualizar/dados/{id}/{ano}',
        [alunosController::class, 'edititaer']
    )->name('aluno.edititaer');

    Route::get(
        '/matricula/Relatorio_matriculas',
        [alunosController::class, 'Relatorio_matriculas']
    )->name('aluno.Relatorio_matriculas');

Route::get(
    '/matricula/atualizacaoIndex/{aluno?}/{dados?}/{ano?}/{metodo?}',
    [alunosController::class, 'atualizacaoIndex']
)->name('aluno.atualizacaoIndex');

    Route::resource('classe', classeController::class);
    Route::get('/classe/disciplinasclasse/{id}/{anolectivo}', [classeController::class, 'disciplinasclasse'])->name('classe.disciplinasclasse');
    Route::get('/classe/disciplinas/{id}/{anolectivo}', [classeController::class, 'disciplinas'])->name('classe.disciplinas');
    Route::get('/classe/disciplinas/guadar_disciplinas', [classeController::class, 'guadar_disciplinas'])->name('classe.guadar_disciplinas');
    Route::get(
        '/matricula/restoryAlunoClasse/{id}',
        [alunosController::class, 'restoryAlunoClasse']
    )->name('aluno.restoryAlunoClasse');

    // apagar o aluno
    Route::get(
        '/Aluno/Apagar/dados/{id}/{ano}',
        [alunosController::class, 'ApagarDados']
    )->name('aluno.ApagarDados');
    // alerta de proibicao
    Route::get(
        '/Aluno/Apagar/dados/alert/{id}/{ano}',
        [alunosController::class, 'mensagemAlerta']
    )->name('aluno.mensagemAlerta');

    Route::get('matricula/imprimir/recibo/{id}/{ano}/{fatura}/{metodo?}/{flag?}', [alunosController::class, 'imprimir_reciboMatricula'])
        ->name('aluno.imprimir_reciboMatricula');
    Route::any('matricula/photo', [alunosController::class, 'photo'])
        ->name('aluno.photo');
        Route::get(
            '/matricula/atualizar/dados/{id}/{ano}',
            [alunosController::class, 'edititaer']
        )->name('aluno.edititaer');

        Route::get(
            '/matricula/Relatorio_matriculas',
            [alunosController::class, 'Relatorio_matriculas']
        )->name('aluno.Relatorio_matriculas');

        Route::get(
            '/matricula/atualizacaoIndex',
            [alunosController::class, 'atualizacaoIndex']
        )->name('aluno.atualizacaoIndex');

     Route::get(
            '/matricula/selecionar_tabelaValores/{classe}/{ano}/{tipo}',
            [alunosController::class, 'selecionar_tabelaValores']
        )->name('aluno.selecionar_tabelaValores');


        Route::resource("pagament",efetuarPagamentoController::class);
        Route::get("pagamento/efetuar",[efetuarPagamentoController::class,"show"])->name('pagament.show');
        Route::get("pagamento/relatorio",[efetuarPagamentoController::class,"relatorio"])->name('pagament.relatorio');
        Route::get("pagamento/relatoriogenerico",[efetuarPagamentoController::class,"relatoriogenerico"])->name(name: 'pagament.relatoriogenerico');


    Route::resource('mensalida', MensalidadesController::class);
    Route::post('mensalida/todas/{id}', [MensalidadesController::class, 'todasMensalidades'])
        ->name('mensalida.todasMensalidades');

    Route::get('mensalida/todas/todos/', [MensalidadesController::class, 'todasMensalidadestodos'])->name('mensalida.todasMensalidadestodos');
    Route::get('mensalida/mes/imprimir/{id}/{idmes}', [MensalidadesController::class, 'imprimirmesMensalidade'])
        ->name('mensalida.imprimirmesMensalidade');
    Route::get('mensalida/todas/todos/{ano}/{classe?}', [MensalidadesController::class, 'todasMensalidadestodosSelect'])->name('mensalida.todasMensalidadestodosSelect');
    Route::get('mensalida/imprimir/{id}/{flag}', [MensalidadesController::class, 'imprimirTodasMensalidadesAluno'])->name('mensalida.imprimirTodasMensalidadesAluno');
    Route::get('mensalida/show/{id}/{mes}', [MensalidadesController::class, 'show'])->name('mensalida.show');
    Route::get('mensalida/todosmeses/{id}', [MensalidadesController::class, 'pagamentostodosMesesIndex'])->name('mensalida.pagamentostodosMesesIndex');
    Route::PUT(
        'mensalida/atualizar/{id}',
        [MensalidadesController::class, 'update']
    )->name('mensalida.update');

    Route::post('mensalidade/atualizardados/{id}', [MensalidadesController::class, 'atualizarMensalidade'])->name('mensalida.atualizar');
    //mensalidades
    Route::get('mensalidade/mes', [MensalidadesController::class, 'TodosAlunosMensalidadede'])->name('mensalidade.meses');
    Route::get('mensalidade/mes/{mes}/{ano}', [MensalidadesController::class, 'Mensalidademes'])->name('mensalidade.mesesSelect');
    Route::get('mensalidade/mes/{mes}/{ano}', [MensalidadesController::class, 'Mensalidademes'])->name('mensalidade.mesesSelect');

    Route::get('mensalidade/Relatorio', [MensalidadesController::class, 'Relatorio'])->name('mensalidade.Relatorio');

    Route::resource('Referencias', refrenciacController::class);

    Route::get('mensalidade/Relatorio', [MensalidadesController::class, 'Relatorio'])->name('mensalidade.Relatorio');
    Route::get('mensalidade/Relatorio/{ano}/{classe}', [MensalidadesController::class, 'RelatorioAnoClasse'])->name('mensalidade.RelatorioAnoClasse');
    Route::get('mensalidade/Relatorio/detalhado/{ano}/{classe}/{mes}', [MensalidadesController::class, 'Relatoriodetalhado'])->name('mensalidade.Relatoriodetalhado');

    Route::get('mensalidade/Relatorio/pagamentos', [MensalidadesController::class, 'pagamentosIndex'])
        ->name('mensalidade.pagamentosIndex');
    Route::get('mensalidade/prencher', [MensalidadesController::class, 'prencher'])
        ->name('mensalidade.prencher');

    Route::get('mensalidade/Relatorio/pagamentos/{ano}/{classe}/{data1}/{data2}', [MensalidadesController::class, 'pagamentos'])
        ->name('mensalidade.pagamentos');

    Route::get('Matricula/Relatorio/pagamentos/{ano}/{classe}/{data1}/{data2}/{tipo}', [alunosController::class, 'pagamentos'])
        ->name('matricula.pagamentos');

    Route::get('matricula/Relatorio/pagamentosPrint/{ano}/{classe}/{data1}/{data2}/{tipo}', [alunosController::class, 'pagamentosprint'])
        ->name('Matricula.pagamentosprint');

    Route::get('mensalidade/Relatorio/pagamentosPrint/{ano}/{classe}/{data1}/{data2}', [MensalidadesController::class, 'pagamentosprint'])
        ->name('mensalidade.pagamentosprint');
});
Route::group(['middleware' => 'auth', 'prefix' => 'RegistoAcademico'], function () {
    Route::resource('ano', anoController::class);

    Route::resource('turma', turmasController::class);
    Route::get('turma/show/{id}/{floag}/{tipo}', [turmasController::class, 'show'])->name('turma.show');
    Route::get('turma/atriburi/professor', [turmasController::class, 'atribuirturma'])->name('turma.atribuirturma');
    Route::get('turma/atriburi/professor/{dados}', [turmasController::class, 'turmasprofesssor'])->name('turma.turmasprofesssor');
    Route::get('turma/atriburi/professor/select/{dados}', [turmasController::class, 'turmasprofesssor'])->name('turma.turmasprofesssor');
    Route::get('turma/atriburi/professores', [turmasController::class, 'professoresselect'])->name('turma.professoresselect');
    Route::get('turma/atriburi/professores/professoresselect/{id}/{classe}/{ano}', [turmasController::class, 'professoresselectdados'])->name('turma.professoresselectdados');
    Route::get('turma/atriburi/professores/professoresselect/ckeck/{id}/{classe}/{ano}/{disciplina}', [turmasController::class, 'turmacheckprofessor'])->name('turma.turmacheckprofessor');

    Route::post('turma/criar/selectore', [turmasController::class, 'criaturmapersonalisada'])->name('turma.criaturmapersonalisada');
       Route::post('turma/criar/prPassado', [turmasController::class, 'criaturmapersonalisadaPORPASSADO'])->name('turma.criaturmapersonalisadaPORPASSADO');
    Route::post('turma/criar/Todas', [turmasController::class, 'guardarTodasTurmas'])->name('turma.guardarTodasTurmas');


    Route::get('turma/atriburi/professores/professoresselect/{id}/turma',
     [turmasController::class, 'turmaclasse'])->name('turma.turmaclasse');


     Route::get('turma/atriburi/{id}/{ano}/turma',
     [turmasController::class, 'anoclasse'])->name('turma.tAD');

     //criar jurris createJurri
     Route::get('turma/criar/createJurri',
     [turmasController::class, 'createJurri'])->name('turma.createJurri');
     //criar jurris createJurri
     Route::get('turma/criar/createJurri',
     [turmasController::class, 'createJurri'])->name('turma.createJurri');


    Route::put('turma/atriburi/professores/guardar', [turmasController::class, 'turmasprofessorGuardar'])
    ->name('turma.turmasprofessorGuardar');



    Route::POST('turma/marcarAlunos', [turmasController::class, 'marcarAlunos'])->name('turma.marcarAlunos');
    Route::get('alunosporanoselecionados/{ano}/{classe}/{id}/{areaDisciplina?}', [turmasController::class, 'alunosporclassano'])->name('turma.alunosporclassano');
    Route::resource('TabelaValores', tabelavaloresController::class);
    Route::get('TabelaValores/{id}/apagar', [tabelavaloresController::class, 'apagar'])
        ->name('TabelaValores.apagar');


        Route::get('TabelaValores/{id}/guadarMensalidades', [tabelavaloresController::class, 'guadarMensalidades'])
        ->name('TabelaValores.guadarMensalidades');



        Route::get('TabelaValores/config/configModalidadepagamento', [tabelavaloresController::class, 'configModalidadepagamento'])
        ->name('TabelaValores.configModalidadepagamento');

        Route::get('TabelaValores/config/adicionarprevilegios/{id}',
        [tipos_pagamentoController::class, 'adicionarprevilegios'])
        ->name('TabelaValores.adicionarprevilegios');


    Route::get('metodosdepagamentos/NovoPagamento', [tipos_pagamentoController::class, 'NovoPagamento'])
        ->name('tipoPagamento.NovoPagamento');
        Route::get('metodosdepagamentos/AtribuirAlunos', [tipos_pagamentoController::class, 'AtribuirAlunos'])
        ->name('tipoPagamento.NovoPagamento');

    Route::PUT('metodosdepagamentos/NovoPagamento', [tipos_pagamentoController::class, 'guardar'])
        ->name('tipoPagamento.guardar');
    Route::PUT('metodosdepagamentos/NovoPagamento/id', [tipos_pagamentoController::class, 'atualizar'])
        ->name('tipoPagamento.atualizar');

    Route::PUT('metodosdepagamentos/NovoPagamento/apagar', [tipos_pagamentoController::class, 'apagar'])
        ->name('tipoPagamento.apagar');

        Route::get('configuracoes/tabela-valores/buscar', [tipos_pagamentoController::class, 'BuscaralunosparaConfig'])
        ->name('tipoPagamento.BuscaralunosparaConfig');

        Route::post('configuracoes/tabela-valores/registar_pagamentos', [tipos_pagamentoController::class, 'registar_pagamentos'])
        ->name('tipoPagamento.registar_pagamentos');

    Route::get('outrosPagamento/index', [outrospagamentoController::class, 'index'])
        ->name('outrosPagamento.index');
    Route::get('outrosPagamento/create', [outrospagamentoController::class, 'create'])
        ->name('outrosPagamento.create');
    Route::PUT('outrosPagamento/guardarConfiguracao', [outrospagamentoController::class, 'guardarConfiguracao'])
        ->name('outrosPagamento.guardarConfiguracao');
    Route::get('outrosPagamento/mostrar', [outrospagamentoController::class, 'show'])
        ->name('outrosPagamento.show');
    Route::get('outrosPagamento/show/{ano}/{classe}/{tipopagamento}', [outrospagamentoController::class, 'mostrarElementos'])
        ->name('outrosPagamento.mostrarElementos');

    Route::get('outrosPagamento/show/{ano}/{classe}/{tipopagamento}/{data}', [outrospagamentoController::class, 'mostrarElementosDomes'])
        ->name('outrosPagamento.mostrarElementosDomes');

        Route::get('outrosPagamento/tipospagamentosShow/{ano}/{classe}', [outrospagamentoController::class, 'tipospagamentosShow'])
        ->name('outrosPagamento.tipospagamentosShow');

    Route::get('outrosPagamento/payrShow/{idaluno}/{idmes}/{tipopagamento}/{flag?}', [outrospagamentoController::class, 'payrShow'])
        ->name('outrosPagamento.payrShow');

    Route::get('outrosPagamento/atualizardados/{id}', [
        outrospagamentoController::class,
        'atualizarMensalidade',
    ])
        ->name('outrosPagamento.atualizarMensalidade');

    Route::get('outrosPagamento/mostraasmensalidadesDotipo/{id}/{tipo}/{flag?}', [
        outrospagamentoController::class,'mostraasmensalidadesDotipo',])->name('outrosPagamento.mostraasmensalidadesDotipo');

Route::get('outrosPagamento/imprimirUnica/{id}/{tipo}/{mes}', [outrospagamentoController::class,'imprimirLinha',])->name('outrosPagamento.imprimirLinha');

    Route::get('outrosPagamento/imprimir/{id}/{tipo}/{flag}', [outrospagamentoController::class, 'imprimirTodasMensalidadesAluno'])->name('outrosPagamento.imprimirTodasMensalidadesAluno');

    Route::get('outrosPagamento/Relatorio', [outrospagamentoController::class, 'Relatorio'])->name('outrosPagamento.Relatorio');
    Route::get('outrosPagamento/Relatorio/{ano}/{classe}/{tipo}', [outrospagamentoController::class, 'RelatorioAnoClasse'])->name('outrosPagamento.RelatorioAnoClasse');
    Route::get('outrosPagamento/Relatorio/detalhado/{ano}/{classe}/{mes}/{tipo}/{flag}', [outrospagamentoController::class, 'Relatoriodetalhado'])->name('outrosPagamento.Relatoriodetalhado');

    Route::get('outrosPagamento/Relatorio/pagamentos', [outrospagamentoController::class, 'pagamentosIndex'])
        ->name('outrosPagamento.pagamentosIndex');

    Route::get('outrosPagamento/Relatorio/pagamentos/{ano}/{classe}/{data1}/{data2}/{tipo}', [outrospagamentoController::class, 'pagamentos'])
        ->name('outrosPagamento.pagamentos');

    Route::get('outrosPagamento/Relatorio/pagamentosPrint/{ano}/{classe}/{data1}/{data2}/{tipo}', [outrospagamentoController::class, 'pagamentosPrint'])
        ->name('outrosPagamento.pagamentosPrint');

    Route::resource('notas', notascontroller::class);
    Route::get('notas/{ano}/{class}', [notascontroller::class, 'turmas'])->name('notas.turmas');
    Route::get('classe/configuracao', [notascontroller::class, 'create'])->name('notas.create');
    Route::get('aluno/notas/Documentos/{id}/{trimestre}/{classe}/{ano}', [notascontroller::class, 'declaracao'])->name('notas.declaracao');
    Route::get('aluno/notas/Documentos/certificado', [notascontroller::class, 'certificado'])->name('notas.certificado');
    Route::POST('notas/dadosImport', [notascontroller::class, 'dadosTable'])->name('notas.dadosTable');
    Route::POST('notas/dadosImport/dadosTablepauta', [notascontroller::class, 'dadosTablepauta'])->name('notas.dadosTablepauta');
    Route::post('notas/tracar', [notascontroller::class, 'trancar'])->name('notas.trancar');
    Route::get('notas/turmasTrimestre/{ano}/{class}/{flag?}', [notascontroller::class, 'turmasTrimestre'])->name('notas.turmasTrimestre');

    Route::get('notas/turmasAlunos/{turma}/{trimestre}', [notascontroller::class, 'turmasAlunos'])->name('notas.turmasAlunos');
    Route::get('notas/elemento/{discipli}/{turma}/{trimestre}', [notascontroller::class, 'elemento'])->name('notas.elemento');
    Route::get('notas/elementoAddavaliacao/{discipli}/{turma}/{trimestre}', [notascontroller::class, 'elementoAddavaliacao'])->name('notas.elementoAddavaliacao');
    Route::get('notas/avaliacao/controle', [notascontroller::class, 'controleavaliacao'])->name('notas.controleavaliacao');
    Route::get('notas/config/disciplinas/{classe}/{anolectivo}', [notascontroller::class, 'disciplinasclassesanolectivo'])->name('notas.disciplinasclassesanolectivo');
    Route::post('notas/config/direcao/classe/{classe}/{anolectivo}', [notascontroller::class, 'RegistodirecaoClasse'])->name('notas.RegistodirecaoClasse');
    Route::get('notas/config/direcao/selecionar/classe/{classe}/{anolectivo}', [notascontroller::class, 'selecionardirecaoClasse'])->name('notas.selecionardirecaoClasse');
    Route::post('notas/disciplinas/guardar/novas/{dados?}/{dados2?}', [notascontroller::class, 'nodadisciplina'])->name('notas.nodadisciplina');

    Route::get('notas/config/disciplinas/lecionadas/{dados?}/{dados2?}', [notascontroller::class, 'disciplinasclassesanolectivo'])->name('notas.lecionadas');
    Route::post('notas/config/disciplinas/Guardar/lecionadas/{dados?}/{dados2?}', [notascontroller::class, 'GuardarDisciplinasACasse'])->name('notas.GuardarDisciplinasACasse');
    Route::post('notas/disciplinas/atualizardisplinas/novas/{dados?}/{dados2}', [notascontroller::class, 'atualizardisplinas'])->name('notas.atualizardisplinas');
    Route::get('notas/disciplinas/edit/novas/{dados}/{dados2}', [notascontroller::class, 'editdisciplina'])->name('notas.editdisciplina');
    Route::get('notas/disciplinas/delete/novas/{dados}', [notascontroller::class, 'deleteDisp'])->name('notas.deleteDisp');
    Route::post('notas/disciplinas/guadardadosprova/{turma}/{trimestre}/{anolectivo}/{classe}/{disciplina}', [notascontroller::class, 'guadardadosprova'])->name('notas.guadardadosprova');
    Route::post('notas/disciplinas/guadarMedia', [notascontroller::class, 'guadarMedia'])
    ->name('notas.guadarMedia');

    Route::post('notas/disciplinas/guardarmedia2', [notascontroller::class, 'guardarmedia2'])
    ->name('notas.guardarmedia2');
 Route::post('notas/disciplinas/precistirbanco', [notascontroller::class, 'precistirbanco'])
    ->name('notas.precistirbanco');
Route::post('notas/disciplinas/precistirbancoExame', [notascontroller::class, 'precistirbancoExame'])
    ->name('notas.precistirbancoExame');

    Route::get('notas/disciplinas/deve/exportnotas/{iddisciplia}/{turmaid}/{trimestre}',
     [notascontroller::class, 'exportnotas'])->name('notas.export');

    //  Route::get('notas/disciplinas/deve/exportnotas/todas/{turmaid}',
    //  [notascontroller::class, 'exportarPautaAnual'])->name('notas.exportTodas');


    Route::post('notas/disciplinas/guadarformulamedias/{turma}/{trimestre}/{anolectivo}/{classe}/{disciplina}', [notascontroller::class, 'guadarformulamedias'])
        ->name('notas.guadarformulamedias');

        Route::post('notas/trimestre/guadarformulamedias/{flag}', [notascontroller::class, 'formulaAnualMedia'])
        ->name('notas.formulaAnualMedia');


Route::post('notas/trimestre/guadarMediaAnual/{flag}', [notascontroller::class, 'guadarMediaAnual'])
        ->name('notas.guadarMediaAnual');

        Route::get('notas/disciplinas/apagarnota/{turma}/{trimestre}/{classe}/{disciplina}',
        [notascontroller::class, 'apagarnota'])
        ->name('notas.apagarnota');

        Route::get('notas/disciplinas/atualizarNome/{turma}/{trimestre}/{classe}/{disciplina}/{novo}',
        [notascontroller::class, 'atualizarNome'])
        ->name('notas.atualizarNome');

        Route::get('notas/disciplinas/notasTrimestrais/{turma}',
        [notascontroller::class,'notasTrimestrais'])
        ->name('notas.notasTrimestrais');

        Route::get('notas/disciplinas/PautadeExame/{turma}/{flag}',
        [notascontroller::class,'PautadeExame'])
        ->name('notas.PautadeExame');

        Route::get('notas/disciplinas/notasTrimestrais/ajax/{turma}',
        [notascontroller::class,'notastrimestraisedita'])
        ->name('notas.notastrimestraisedita');

        Route::get('notas/disciplinas/notasTrimestrais/ajax/dados/{turma}',
        [notascontroller::class,'notastrimestraiseditadados'])
        ->name('notas.notastrimestraiseditadados');


        //configuracoes gerais de trimestre das classe
        Route::get('notas/disciplinas/notasTrimestrais/painel/configuracoes/',
        [notascontroller::class,'ConfiguracoesTrimestrais'])
        ->name('notas.ConfiguracoesTrimestrais');

  //configuracoes gerais de trimestre das classe Conteudo
        Route::get('notas/disciplinas/notasTrimestrais/painel/configuracoes/{ano}/{classe}',
        [notascontroller::class,'ConfiguracoesTrimestraisano'])
          ->name('notas.ConfiguracoesTrimestraisano');

//mostrar Lista de Alunos
        Route::get('notas/disciplinas/painel/ListadosAlunos/{ano}/{classe}/{tipoDoc}',
        [notascontroller::class,'ListadosAlunos'])
          ->name('notas.ListadosAlunos');


        //configuracoes gerais de trimestre das classe trancar
        Route::post('notas/disciplinas/notasTrimestrais/painel/configuracoes/TrancarTrimestreAll',
        [notascontroller::class,'TrancarTrimestreAll'])
        ->name('notas.TrancarTrimestreAll');

Route::get('notas/disciplinas/notasAnualExame/show/dados',
        [notascontroller::class,'notasAnualExame'])
        ->name('notas.notasAnualExame');

        Route::get('notas/disciplinas/notasTrimestrais/show/dados',
        [notascontroller::class,'notasTrimestraisshow'])
        ->name('notas.notasTrimestraisshow');


Route::post('notas/guardar/dados',
        [notascontroller::class,'calcularMedia'])
        ->name('notas.calcularMedia');

        Route::get('notas/disciplinas/notasTrimestrais/Imprimir/Pauta/anual',
        [notascontroller::class,'exportarPautaAnual'])
        ->name('notas.exportarPautaAnual');

        // Route::Post('notas/disciplinas/notasTrimestrais/Imprimir/Pauta/anual',
        // [notascontroller::class,'ImprimirPautaAnual'])
        // ->name('notas.ImprimirPautaAnual');

        Route::Post('notas/disciplinas/notasTrimestrais/Gerar/Resultado/anual',
        [notascontroller::class,'gerarResultado'])
        ->name('notas.gerarResultado');


         Route::get('notas/anual/disciplinas/painel',
        [notascontroller::class,'PainelDocumetos'])
        ->name('notas.PainelDocumetos');

});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/webcam', function () {
    return view('include.camera');
})->middleware('auth');

Route::get('/adicionarelementos', function () {
    $alunos = Aluno::all();
    $alunosclasess = alunoClasse::all();
    foreach ($alunos as $alunosItem) {

        alunoClasse::create(['aluno_id' => $alunosItem->id, 'classe_id' => 1, 'anolectivo_id' => 3]);
        alunoClasse::create(['aluno_id' => $alunosItem->id, 'classe_id' => 2, 'anolectivo_id' => 8]);
        alunoClasse::create(['aluno_id' => $alunosItem->id, 'classe_id' => 3, 'anolectivo_id' => 7]);
    }
})->middleware('auth');
Route::get('/adicionarelementos/mensalidades', function () {
    $alunos = Aluno::all();
    $alunosclasess = alunoClasse::all();

    foreach ($alunosclasess as $alunosItem) {

        for ($x = 1; $x < 13; $x++) {
            mensalidade::create(['aluno_classe_id' => $alunosItem->id, 'mes_id' => $x, 'Estado' => 'Não Pago']);
        }
    }
})->middleware('auth');

Auth::routes();
Route::get('/dashboard/financeiro', [App\Http\Controllers\HomeController::class, 'relatorioPagamentos'])->name('dashboard.financeiro');
Route::get('/dashboard/financeiro/dados', [App\Http\Controllers\HomeController::class, 'relatorioPagamentos'])->name('dashboard.financeiro');

Route::get('/dados/test',function(){

phpinfo();
})->name('dados.test');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home/vitrine', [App\Http\Controllers\HomeController::class, 'vitrine'])->name('home.vitrine')->middleware('auth');

Route::get('/home/dados/{ano}/{data1}/{data2}/{tipo}', [App\Http\Controllers\HomeController::class, 'homedados'])->name('home.dados')->middleware('auth');

Route::get('/home/mostrarDiaria/{ano}/{data1}/{data2}/{tipo}', [App\Http\Controllers\HomeController::class,
    'mostrarDiaria'])
    ->name('home.mostrarDiaria')->middleware('auth');

Route::get('/home/mostrarMensal/{ano}/{data1}/{data2}/{tipo}',
    [App\Http\Controllers\HomeController::class,
        'mostrarMensal'])
    ->name('home.mostrarMensal')->middleware('auth');

Route::get('/home/MostrarEsperado/{ano}/{data1}/{data2}/{tipo}',
    [App\Http\Controllers\HomeController::class,
        'MostrarEsperado'])
    ->name('home.MostrarEsperado')->middleware('auth');

Route::group(
    [' middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'],
    function () {

        Route::get('Usuarios/funcionarios', [usuarioController::class, 'index'])->name('Usuarios.funcionarios')->middleware('auth');

        Route::get('Usuarios/ApagarPermanete/{id}', [usuarioController::class, 'ApagarDefinitivo'])->name('Usuarios.ApagsrDefinitivo')->middleware('auth');
        Route::get('Usuarios/perfil', [usuarioController::class, 'perfil'])->name('Usuarios.perfil')->middleware('auth');
        Route::Put('Usuarios/AtualizarPerfil/{id}', [usuarioController::class, 'AtualizarPerfil'])->name('Usuarios.AtualizarPerfil')->middleware('auth');
        Route::get('Usuarios/AtualizarSenha/{id}', [usuarioController::class, 'Atualizarsenha'])->name('Usuarios.Atualizarsenha')->middleware('auth');
        Route::get('Usuarios/edit/{id}/{flag?}', [usuarioController::class, 'edit'])->name('Usuarios.edit')->middleware('auth');
        Route::get('Usuarios/show/{id}', [usuarioController::class, 'show'])->name('Usuarios.show')->middleware('auth');
        Route::Delete('Usuarios/destroy/{id}', [usuarioController::class, 'destroy'])->name('Usuarios.destroy')->middleware('auth');
        Route::PUT('Usuarios/update/{id}', [usuarioController::class, 'update'])->name('Usuarios.update')->middleware('auth');
        Route::get('Usuarios/create', [usuarioController::class, 'create'])->name('Usuarios.create')->middleware('auth');
        Route::get('Usuarios/userrestore/{id} ', [usuarioController::class, 'userrestore'])->name('Usuarios.userrestore')->middleware('auth');
        Route::POST('Usuarios/store', [usuarioController::class, 'store'])->name('Usuarios.store');
        Route::get('Usuarios/', [usuarioController::class, 'index'])->name('Usuarios.index')->middleware('auth');

        Route::PUT('Usuarios/updatesenha/{id}', [usuarioController::class, 'updatesenha'])->name('Usuarios.updatesenha')->middleware('auth');

        Route::get('permissons/lista', [aclController::class, 'index'])->name('Admin.permissons.lista');
        Route::get('permissons/Apagar/{id}', [aclController::class, 'destroy'])->name('Admin.permissons.apagar')->middleware('auth');
        Route::post('permissons/Guardar', [aclController::class, 'store'])->name('Admin.permissons.guardar')->middleware('auth');
        Route::get('permissons/edit/{id}', [aclController::class, 'edit'])->name('Admin.permissons.edit')->middleware('auth');
        Route::PUT('permissons/update/{id}', [aclController::class, 'update'])->name('Admin.permisson.atualizar')->middleware('auth');
        Route::get('permissons/papel/{id}', [aclController::class, 'papelEdit'])->name('Admin.permisson.papel')->middleware('auth');
        Route::post('permissons/papel/Adicionar', [aclController::class, 'permissaoAdincionarpapel'])->name('Admin.permisson.papel.Adicionar')->middleware('auth');
        Route::get('permissons/usuario/{id?}', [aclController::class, 'Editusuario'])->name('admin.usuario.previlegio')->middleware('auth');
        Route::post('permissons/usuario/Adicionar', [aclController::class, 'adicionarprevilegiouser'])->name('admin.usuario.previlegio.adiccionar')->middleware('auth');

        ROute::get('/RegistoOperacoes/index', [usuarioController::class, 'observadorIndex'])->name('Usuarios.RegistoOperacoes')->middleware('auth');
        ROute::get('/RegistoOperacoes/usuario/{id}', [usuarioController::class, 'operacoesshow'])->name('Usuarios.operacoesshow')->middleware('auth');
        ROute::get('/RegistoOperacoes/detalhes/{id}', [usuarioController::class, 'detalhes'])->name('Usuarios.detalhes')->middleware('auth');

    }
);

Route::resource('Configuracoes', configuracoesController::class)->middleware('auth');
Route::get('Admin/Configuracoes/{id}/edit', [configuracoesController::class, 'edit'])->name('Configuracoes.edit');

Route::resource('Financas', bancosControler::class)->middleware('auth');
// Route::resource('Financas', bancosControler::class)->middleware('auth');

Route::get('Financas/Banco/configuracoes', [bancosControler::class, 'create'])->name('Financas.create')->middleware('auth');
Route::get('Financas/Banco/gerarReferencia/{Entidade}/{Servico}/{codigoAluno}/{mes}', [bancosControler::class, 'gerarReferencia'])->name('Financas.gerarReferencia')->middleware('auth');
Route::post('Financas/Banco/CaregarReferencias/{ano}/', [bancosControler::class, 'uplodefileCadastrofile'])->name('Financas.uplodefileCadastrofile')->middleware('auth');
Route::get('Financas/Banco/referencas/show', [bancosControler::class, 'visuzlizarreferencias'])->name('Financas.visuzlizarreferencias')->middleware('auth');
Route::get('Financas/Banco/referencas/{tipo}/{ano}/{classe}', [bancosControler::class, 'getmeses'])->name('Financas.getmeses')->middleware('auth');

Route::get('Financas/Banco/referencas/alunoReferencias', [bancosControler::class,
    'alunoReferealunoReferenciasPrintncias'])
    ->name('Financas.alunoReferencias')->middleware('auth');

    Route::post('Financas/Banco/referencas/gerar/{id}/{entidade}', [bancosControler::class,
    'gerarReferenciainnline'])
    ->name('Financas.gerarReferenciainnline')->middleware('auth');

Route::get('Financas/Banco/referencas/alunoReferenciasPrint/{id}/{idtipo}/{mesid}', [bancosControler::class,
    'alunoReferenciasPrint'])
    ->name('Financas.alunoReferenciasPrint')->middleware('auth');




    Route::get('/Mpesapagamento/visualizar/{id}', [mpesaController::class, 'index'])->name('Mpesa.tela1');


    Route::post('/enviar/sms', [smsNotificacaoController::class, 'sendSms'])->name('sms.send');
    Route::post('/sms/receive', [smsNotificacaoController::class, 'receive'])->name('sms.receive');
    Route::get('/sms/noticiacao',[smsNotificacaoController::class,'index'])->name('sms.dadosshow');;


    Route::resource("BDNotificao",NotificacaoController::class);


});
  Route::get('/enviar-pagamento', [mpesaController::class, 'makePayment'])->name('enviar-pagamento');
Route::prefix('mpesa/test')->group(function () {
    Route::get('/config', [MpesaController::class, 'testConfig']);
    Route::get('/token', [MpesaController::class, 'testToken']);
});



;

// Rota para alternar o estado do menu
Route::post('/toggle-menu-state', [MenuController::class, 'toggleState'])->name('toggle.menu.state');
Route::get('/get-menu-state', [MenuController::class, 'getState'])->name('get.menu.state');

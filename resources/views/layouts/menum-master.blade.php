{{-- ============================= --}}
{{-- 🔧 BLOCO PHP LIMPO --}}
{{-- ============================= --}}
@php
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;




$direcao = DB::table("classe_direcao")
    ->where(function($query) {
        $query->where("director_id", auth()->user()->id)
              ->orWhere("pedagogico_id", auth()->user()->id);
    })
    ->exists(); // More efficient than first() ? true : false
    
    
    $isnotas= Gate::check('Ver-Notas')
        ||Gate::check("Caderneta-Caregar")
        || Gate::check('Alterar-Notas');
$tipospagamentos = DB::table('tipos_pagamentos')->get();

$isHome        = Request::is('home*');
$isAcademico   = Request::is('RegistoAcademico/turma*') ||
                 Request::is('RegistoAcademico/notas*') || 
                 Request::is('aluno*');
$isFinancas    = Request::is('Financas*');

// FLAGS PERMISSÃO
$canAccess = false;
$McanAccess = false;
$canLista = false;

foreach ($tipospagamentos as $item) {
    $desc = trim($item->Descricao);
    $canAccess = $canAccess || Gate::check("Efetuar-$desc") || Gate::check("Visualizar-$desc");
    $McanAccess = $McanAccess || Gate::check("Lista-$desc");
    $canLista = $canLista || Gate::check("Visualizar-$desc");
}

// PROFESSOR / DIREÇÃO
$autor = Auth::user()->id;

$preshow = DB::table('professor_turmaview')
    ->where('professor_id', $autor)
    ->get();

$direcao = DB::table('classe_direcao')
    ->where("pedagogico_id", $autor)
    ->orWhere("director_id", $autor)
    ->first();
  $isfinacas= Gate::check('Dashabord-Financas') || Gate::check('Visualizar-Referencias')||Gate::check('Criar-Referencias');
    $isturmas=Gate::check('criar-Turma')||Gate::check('criar-Jurri')||Gate::check('atribuir-turmas');
$validarTURMAS = !$preshow->isEmpty() || !empty($direcao);
$permitir = $canAccess || $McanAccess || $validarTURMAS;

// PERMISSÕES MATRÍCULA
$canMatriculaExterna = Gate::check("Efetuar-".trim($tipospagamentos->where("id",1)->first()->Descricao));
$canMatriculaInterna = Gate::check("Efetuar-".trim($tipospagamentos->where("id",2)->first()->Descricao));
$canVisualizarMatricula = Gate::check("Visualizar-".trim($tipospagamentos->where("id",1)->first()->Descricao)) || 
                          Gate::check("Visualizar-".trim($tipospagamentos->where("id",2)->first()->Descricao));
$canRelatorioMatricula = Gate::check("RelatorioPagameto-".trim($tipospagamentos->where("id",1)->first()->Descricao)) || 
                         Gate::check("RelatorioPagameto-".trim($tipospagamentos->where("id",2)->first()->Descricao));

$isMatricula = Request::is('aluno/matricula*') ||
               Request::is('aluno/aluno*') ||
               Request::is('aluno/matricula/atualizar/dados/*') ||
               Request::is('aluno/mostrar');

@endphp

{{-- ============================= --}}
{{-- 👤 USER PANEL --}}
{{-- ============================= --}}
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="info">
        <a href="{{ route('Usuarios.Atualizarsenha', Auth()->user()->id) }}">
            <i class="fa fa-pencil-square"></i> Alterar Senha
        </a>
    </div>
</div>

{{-- ============================= --}}
{{-- 📌 MENU --}}
{{-- ============================= --}}
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

        {{-- ============================= --}}
        {{-- 🏠 HOME --}}
        {{-- ============================= --}}
        <li class="nav-item">
            <a href="/home" class="nav-link {{ $isHome ? 'active' : '' }}">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>Página Inicial</p>
            </a>
        </li>

        {{-- ============================= --}}
        {{-- 🎓 REGISTO ACADÉMICO --}}
        {{-- ============================= --}}
        @if ($permitir||Gate::check('Ver-Aluno')||Gate::check('Modificar-Estado')||Gate::check('Editar-Aluno')
       ||$isnotas
        ||$direcao
        || $isturmas
        ||$isfinacas
        )
            <li class="nav-item has-treeview {{ $isAcademico ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isAcademico ? 'active' : '' }}">
                    <i class="nav-icon fa fa-graduation-cap"></i>
                    <p>
                        Registo Académico
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">

                    {{-- ============================= --}}
                   
                    {{-- ============================= --}}
                    @if($canMatriculaExterna || $canMatriculaInterna || $canVisualizarMatricula || $canRelatorioMatricula 
                    ||Gate::check('Ver-Aluno')||Gate::check('Modificar-Estado')||Gate::check('Editar-Aluno'))
                        <li class="nav-item has-treeview {{ $isMatricula ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ $isMatricula ? 'active' : '' }}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Matrícula
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                @can("Efetuar-MATRICULA EXTERNOS")
                                    <li class="nav-item">
                                        <a href="{{ route('aluno.matricula') }}"
                                           class="nav-link {{ Request::is('aluno/matricula') ? 'active' : '' }}">
                                            <i class="fa fa-pencil-square nav-icon"></i>
                                            <p>Efetuar</p>
                                        </a>
                                    </li>
                                @endcan

                                @can("Efetuar-MATRICULA INTERNOS")
                                    <li class="nav-item">
                                        <a href="{{ route('aluno.atualizacaoIndex') }}"
                                           class="nav-link {{ Request::is('aluno/matricula/atualizacaoIndex') ? 'active' : '' }}">
                                            <i class="fa fa-refresh nav-icon"></i>
                                            <p>Atualizar</p>
                                        </a>
                                    </li>
                                @endcan

                                @if($canVisualizarMatricula||Gate::check('Ver-Aluno')||Gate::check('Modificar-Estado')||Gate::check('Editar-Aluno'))
                                    <li class="nav-item">
                                        <a href="{{ route('aluno.mostrar') }}"
                                           class="nav-link {{ Request::is('aluno/mostrar') || Request::is('aluno/matricula/atualizar/dados/*') ? 'active' : '' }}">
                                            <i class="fa fa-eye nav-icon"></i>
                                            <p>Alunos Inscritos</p>
                                        </a>
                                    </li>
                                @endif

                                @if($canRelatorioMatricula)
                                    <li class="nav-item">
                                        <a href="{{ route('aluno.Relatorio_matriculas') }}"
                                           class="nav-link {{ Request::is('aluno/matricula/Relatorio_matriculas') ? 'active' : '' }}">
                                            <i class="fa fa-bar-chart nav-icon"></i>
                                            <p>Relatório</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- OUTROS COMPONENTES --}}
                    @include("Componetes.menum-componente")
                    @include("Componetes.menum-componente-notas")
                    @include("Componetes.menum-Gestao-turma")

                </ul>
            </li>
        @endif

        @include("Componetes.menum-GESTAOfINACEIRA")

        {{-- ============================= --}}
        {{-- ⚙️ ADMINISTRAÇÃO --}}
        {{-- ============================= --}}
        @include("Componetes.menum-ADMISTRACAOaVANCADA")

    </ul>
</nav>
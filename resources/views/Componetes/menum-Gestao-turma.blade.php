@php
$isTurma = Request::is('RegistoAcademico/turma*');


$direcao = DB::table("classe_direcao")
    ->where(function($query) {
        $query->where("director_id", auth()->user()->id)
              ->orWhere("pedagogico_id", auth()->user()->id);
    })
    ->exists(); // More efficient than first() ? true : false
    
    


@endphp

@if($direcao||Gate::check('criar-Turma')||Gate::check('criar-Jurri')||Gate::check('atribuir-turmas') )
<li class="nav-item has-treeview {{ $isTurma ? 'menu-open' : '' }}">

    <a href="#" class="nav-link {{ $isTurma ? 'active' : '' }}">
        <i class="nav-icon fa fa-sitemap"></i>
        <p>
            Gestão de Turmas
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        {{-- Criar Turma --}}
        @can('criar-Turma')
        <li class="nav-item">
            <a href="{{ route('turma.create') }}"
               class="nav-link {{ Request::is('RegistoAcademico/turma/create') ? 'active' : '' }}">
                <i class="fa fa-plus-square nav-icon"></i>
                <p>Criar Turma</p>
            </a>
        </li>
        @endcan

        {{-- Atribuir Professor --}}
        @if( Gate::check('atribuir-turmas')|| $direcao)
        <li class="nav-item">
            <a href="{{ route('turma.atribuirturma') }}"
               class="nav-link {{ Request::is('RegistoAcademico/turma/atriburi/professor') ? 'active' : '' }}">
                <i class="fa fa-exchange nav-icon"></i>
                <p>Atribuir Professor</p>
            </a>
        </li>
        @endif

        {{-- Criar Júri --}}
        @if (Gate::check('criar-Jurri')||$diracao)
        <li class="nav-item">
            <a href="{{ route('turma.createJurri') }}"
               class="nav-link {{ Request::is('RegistoAcademico/turma/criar/createJurri') ? 'active' : '' }}">
                <i class="fa fa-users nav-icon"></i>
                <p>Criar Júri</p>
            </a>
        </li>
        @endif

    </ul>
</li>
@endif

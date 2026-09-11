@php
$direcao = DB::table("classe_direcao")
    ->where(function($query) {
        $query->where("director_id", auth()->user()->id)
              ->orWhere("pedagogico_id", auth()->user()->id);
    })
    ->exists(); // More efficient than first() ? true : false



@endphp

@if(Gate::check('Ver-Notas')
        || Gate::check('Alterar-Notas')
         || Gate::check('gestao-notas')||$direcao)
<li class="nav-item has-treeview {{ Request::is('RegistoAcademico/notas*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('RegistoAcademico/notas*') ? 'active' : '' }}">
        <i class="nav-icon fa fa-book"></i>
        <p>
            Gestão de Notas
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        {{-- Lançamento --}}
        @if($validarTURMAS || Gate::check("Caderneta-Caregar")|| Gate::check('Ver-Notas')
        || Gate::check('Alterar-Notas')
         || Gate::check('gestao-notas')||$direcao)
        <li class="nav-item">
            <a href="{{ route('notas.index') }}"
               class="nav-link {{ Request::is('RegistoAcademico/notas') ? 'active' : '' }}">
                <i class="fa fa-pencil nav-icon"></i>
                <p>Lançamento</p>
            </a>
        </li>
        @endif

        {{-- Pauta --}}
        @if(Gate::check("ver-pauta")||$direcao )
        <li class="nav-item">
            <a href="{{ route('notas.notasTrimestraisshow') }}"
               class="nav-link {{ Request::is('RegistoAcademico/notas/disciplinas/notasTrimestrais/show/dados') ? 'active' : '' }}">
                <i class="fa fa-table nav-icon"></i>
                <p>Pauta Trimestral</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('notas.notasAnualExame') }}"
               class="nav-link {{ Request::is('RegistoAcademico/notas/disciplinas/notasAnualExame/show/dados') ? 'active' : '' }}">
                <i class="fa fa-table nav-icon"></i>
                <p>Pauta de Exame</p>
            </a>
        </li>
        @endif

        {{-- Configurações --}}

         @if($direcao ||Gate::check("Configuracoes-Trimestrais"))
        <li class="nav-item">
            <a href="{{ route('notas.ConfiguracoesTrimestrais') }}"
               class="nav-link {{ Request::is('RegistoAcademico/notas/disciplinas/notasTrimestrais/painel/configuracoes') ? 'active' : '' }}">
                <i class="fa fa-cogs nav-icon"></i>
                <p>Configurações</p>
            </a>
        </li>


@endif
@can("Gerar-Documento")
        {{-- Documentos --}}
        <li class="nav-item">
            <a href="{{ route('notas.PainelDocumetos') }}"
               class="nav-link {{ Request::is('RegistoAcademico/notas/anual/disciplinas/painel') ? 'active' : '' }}">
                <i class="fa fa-folder nav-icon"></i>
                <p>Documentos</p>
            </a>
        </li>
        @endcan

    </ul>
</li>
@endif


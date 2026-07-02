


<ul class="nav nav-tabs listaTurmaTab" id="myTab" role="tablist">



       @if ($turmasclasse[0]->Descricao==null)

        <li class="list-group-item list-group-item-warning text-center rounded shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            As Jurri ainda não foram configuradas
        </li>
    @else

    @foreach ($turmasclasse as $key => $turmasnoes)




@php


$turmasnoes=(object) $turmasnoes;
$usuario = Auth::user()->id;

$anolectivo = DB::table('classe_direcao')
    ->where("classe_id", $turmasnoes->classe_id)
    ->max("anolectivo_id");

$dadosChave = DB::table('classe_direcao')
    ->where("classe_id", $turmasnoes->classe_id)
    ->where("anolectivo_id", $anolectivo)
    ->where(function ($query) use ($usuario) {

        $query->where("pedagogico_id", $usuario)
              ->orWhere("director_id", $usuario);

    })
    ->first();

    $edicaoativa=false;


     $turmapermisao=DB::table('professor_turmaview')->where("professor_id",$usuario)
    ->where("Tipo_Docencia_id",1)
    ->where("turma_id",$turmasnoes->id)->first();
    if($turmapermisao||$dadosChave){
   $edicaoativa=true;
    }


// dd($usuario,$turma,$edicaoativa);
@endphp


@if($edicaoativa|| Gate::check("ver-pauta"))

        <li class="nav-item">
            <a class="nav-link @if($key == 0) active @endif turmaselecionada"
               id="{{ $turmasnoes->id}}"
               flag="0"
                {{-- turmas --}}
               data-toggle="tab"
               href="#turma-{{ $turmasnoes->id }}"
               role="tab"
               aria-controls="turma-{{ $turmasnoes->id }}"
               aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
               {{ $turmasnoes->Descricao }}
            </a>
        </li>
        @endif

    @endforeach
@endif


</ul>


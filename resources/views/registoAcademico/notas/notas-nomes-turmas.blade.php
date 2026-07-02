<ul class="list-group my-3">



    @if (empty($turmas) || empty($turmas[0]))

        <li class="list-group-item list-group-item-warning text-center rounded shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            As turmas ainda não foram configuradas
        </li>
    @else




        @foreach ($turmas as $key => $turmaItem)



        @php


$autor=Auth::user()->id;


$preshow = DB::table('professor_turmaview')
    ->where('professor_id', $autor)
    ->where('turma_id', $turmaItem->id) // certifica que esta variável existe
    ->where('ano_lectivo_id', $turmaItem->ano_lecttivo_id) // idem
    ->orderBy('classe_id')
    ->orderBy('turma_id')
    ->orderBy('disciplina_id')
    ->get();

$direaca = DB::table('classe_direcao')
->where("classe_id",$turmaItem->classe_id)
->where('anolectivo_id', $turmaItem->ano_lecttivo_id)
->where(function($quere) use ($autor){
    $quere->where('pedagogico_id', $autor)
->orWhere('director_id', $autor);
})
->first();

// dd($direaca,$preshow,Gate::check("Caderneta-Caregar"));

$validarTURMAS = false;




if ($preshow->isNotEmpty() || !is_null($direaca) || Gate::check("Caderneta-Caregar")) {
    $validarTURMAS = true;
}

// dd($validarTURMAS,$direaca,$preshow,Gate::check("Caderneta-Caregar"));


@endphp
@if($validarTURMAS)
            <li
                class="list-group-item list-group-item-action Turma-elemento d-flex justify-content-between align-items-center mb-2 shadow-sm rounded
                {{ $key ==0 ? 'active  text-white border-0' : '' }}"

                id="{{ $turmaItem['id'] }}"
                data-key="{{ $key }}"
                style="cursor: pointer; transition: all 0.2s ease;"
            >


                <div class="d-flex align-items-center">
                    <i class="bi bi-building me-2 {{ $key === 0 ? 'text-white' : 'text-primary' }}"></i>
                    <span>{{ $turmaItem['Descricao'] }}</span>
                </div>

                <span class="badge {{ $key === 0 ? 'bg-light text-primary' : 'bg-primary' }} rounded-pill">
                    {{ $key + 1 }}
                </span>

            </li>
              @endif

        @endforeach

    @endif

</ul>

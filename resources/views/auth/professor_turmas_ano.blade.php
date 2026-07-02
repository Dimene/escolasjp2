<?php $turmasporclass = collect(); ?>
<table class="table table-responive table-bordered">
    <tr style="background-color: rgba(80, 80, 75, 0.289)">
        <th>Classe</th>
        @foreach ($classes as $key => $classesItem)
            <?php
            $dados = $turmas->where('classe_id', $classesItem->classe_id);
            $turmasporclass->push($dados); ?>
            <th colspan="{{ count($turmasporclass[$key]->pluck('disciplinas')->unique()) }}">
                {{ $classesItem->classe }}

            </th>
        @endforeach
    </tr>
    <tr>
        <th>Disciplinas</th>
        <?php $turmasselecionadas = collect(); ?>
        @foreach ($turmasporclass as $key => $item)
            @foreach ($item->pluck('disciplinas')->unique() as $key => $itemDis)
                <td>
                    {{ $itemDis }}
                </td>
            @endforeach
        @endforeach

    </tr>

    <tr>
        <th>
            Turmas
        </th>
        @foreach ($turmasporclass as $key => $item)
            <?php $disciplina = $item->pluck('disciplinas')->unique(); ?>
            @foreach ($disciplina as $key => $Item2)
                <td>
                    @foreach ($item->where('disciplinas', $Item2) as $Item3)
                        {{ $Item3->turma }},
                    @endforeach
                </td>
            @endforeach
        @endforeach
    </tr>
</table>

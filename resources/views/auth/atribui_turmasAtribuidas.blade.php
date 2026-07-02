<div class="form-group">
    <label for="my-select">Selecione o Ano lectivo</label>
    <select id="my-select" class="form-control" name="Anolectivo_classe" idFuncionario='{{ $id }}'>

        @foreach ($anos as $anosItem)
            <option value="{{ $anosItem->ano_lectivo_id }}">{{ $anosItem->anolectivo }}</option>
        @endforeach

    </select>

    <?php $classes = '';
    $disciplinasselecionadas = collect();
    $arryTurmas = [];
    ?>

    <div class="conteudoTurmas">

    </div>

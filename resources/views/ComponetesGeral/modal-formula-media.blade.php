{{--  calcular media Anual   --}}
<div id="criarFormulaMedia" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <center>
                <label> Criar formula para Media Anual</label>
            </center>
            <div class="modal-body">
                @foreach ($classe_disciplinas as $classe_disciplinasItem)
                    <button class="btn btn-avaliacaofeitasMedia"
                        value="{{ $classe_disciplinasItem->disciplina->Sigla }}">{{ $classe_disciplinasItem->disciplina->Sigla }}</button>
                @endforeach

                <div class="row">
                    <div class="col-2"><label>@Media</label></div>
                    <div class="col">
                        <input class="form-control" name="formmulacriadaParamedia" />
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-guadarformulamediaAnual"> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--  calcular media    --}}


{{--  calcular media   --}}
<div id="criarFormula" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <center>
                    <h5> Crie a formula por favor </h5>
                </center>
                <hr>
                <div class="row">
                    <div class="col"><label for="nome-nota">@Media=</label></div>
                    <div class="col-8">
                        <div class="form-group">
                            <div class="row">
                                @foreach ($divisoes as $divisoesItem)
                                    <button class="badge badge-Primary btn-avaliacaofeitas ">
                                        {{ $divisoesItem->divisao }}{{ 'NF' }}
                                    </button>
                                @endforeach
                            </div>
                            <form action="" method="POST" id="formularioformula">
                                @csrf
                                <input name="anolectivo" value="{{ $classe_disciplinas[0]['anolectivo_id'] }}"
                                    type="hidden">
                                <input name="turma" value="{{ $turma }}" type="hidden">
                                <input id="my-select" type="text" class="form-control" name="formmulacriada"
                                    @if (!empty($formunlamendia)) value="{{ $formunlamendia->formula }}" @endif
                                    list="lista-label-avaliacao">

                                @if (!empty($formunlamendia))
                                    <script>
                                        var formula = "<?php echo $formunlamendia->formula; ?>"
                                    </script>
                                @endif
                                <datalist id="lista-label-avaliacao">

                                    @foreach ($divisoes as $divisoesItem)
                                        <option>{{ $divisoesItem->divisao }}NF</option>
                                    @endforeach

                                </datalist>
                        </div>
                        {{--  <input id="input-nomeprova" class="form-control" type="text">  --}}
                    </div>

                    <div class="col"> <a name="" id=""
                            class="btn btn-primary  btn-guadarformulamedia config-item-Div" href="#"
                            role="button">Guardar</a></div>




                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


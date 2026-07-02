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

@if($divisoes->where('divisao_id', 900)->isNotEmpty())
 <button class="badge bg-Primary btn-avaliacaofeitas col">
                                       NA
                                    </buptton>
                                    <button class="badge bg-Primary btn-avaliacaofeitas
                                     col ">
                                       NE
                                    </button>
@else
    @foreach ($divisoes as $divisoesItem)
        {{-- Percorre todos os itens --}}

                                @if($divisoesItem->divisao<>100)
                                    <button class="badge badge-Primary btn-avaliacaofeitas ">
                                        {{ $divisoesItem->divisao }}{{ 'NF' }}
                                    </button>
                                    @endif
                                @endforeach
                                @endif
                            </div>
                            <form action="" method="POST" id="formularioformula">
                                @csrf
                                <input name="anolectivo" value="{{ $classe_disciplinas[0]['anolectivo_id'] }}"
                                    type="hidden">

                                <input name="turma" value="{{ $turma }}" type="hidden">
                                <input id="my-select" type="text" class="form-control" name="formmulacriada"
                                    value="{{ $formunlamendia->where("TipoMedia",1)->first()->formula??null }}"
                                    list="lista-label-avaliacao">


                                    <script>
                                        var formula = @json($formunlamendia->where("TipoMedia",1)->first()->formula??null)
                                    </script>

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
                       <input class="form-control" name="formmulacriadaParamedia"
    value="{{ isset($coleccaoalunos[0]['MediaFormulaAnual']) ? $coleccaoalunos[0]['MediaFormulaAnual'] : '' }}" />
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-guadarformulamediaAnual"> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modal de Fechamento de Trimestre --}}
<div id="FecharTrimestre" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                @php
                    $colecao = collect($resultadotRANCA);

                @endphp
                <h5 class="modal-title">Fechamento do {{ $notasTodoano[0]->anomodelos }}</h5>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach ($notasTodoano as $item)
                        @php
                         $TRACA = "fa-unlock toggle-lock";
                    $TRACAbloqieio = false;
                    $cor = "";
                    $flag="Aberto";
                  //  dd($colecao);
                            $dados = $colecao->where("divisao_id", $item->anomodelo_id)->first();

                            if (!empty($dados) && $dados["fechamento"] == "TOTAL") {
                                $TRACA = "fa-lock";
                                $TRACAbloqieio = true;
                                $cor = "text-danger";
                                 $flag="Total";
                            } if (!empty($dados) && $dados["fechamento"] == "PARCIAL") {
                                $TRACA = "fa-lock toggle-lock";
                                $TRACAbloqieio = false;
                                $cor = "text-orange";
                                 $flag="parcial";
                            }
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center trimestre-item"
                            data-trimestre-id="{{ $item->anomodelo_id }}"
                            data-trimestre-nome="{{ $item->divisao }} {{ $item->anomodelos }}"
                            data-trancado="{{ $TRACAbloqieio }}">
                            <span>{{ $item->divisao }} {{ $item->anomodelos }}</span>
                            <i class="fa {{ $TRACA }} {{ $cor }}" style="cursor:pointer;"> <span class="btn-badge">{{ $flag }}</span></i>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" id="btnTrancarSelecionados">
                    Trancar Selecionados
                </button>
            </div>
        </div>
    </div>
</div>

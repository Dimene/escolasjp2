<style id="pagamento-lista-estilos">
    .pagamento-parcelas .list-group-item {
        transition: background-color .2s ease;
    }

    .pagamento-parcelas .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .pagamento-parcelas .checkbox-pagamento:checked + label strong {
        color: #28a745;
    }

    .pagamento-parcelas-detalhes {
        border-left: 2px solid #e9ecef;
        margin-left: .45rem;
    }

    .pagamento-parcela {
        padding-top: .35rem;
        padding-bottom: .35rem;
    }

    .pagamento-vazio {
        padding: 1.5rem;
    }
</style>

<div id="conteudoListaPagamentos">
<ul class="list-group pagamento-parcelas" id="listaPagamentosTab">
    @forelse ($tabelavalores as $descricao => $registos)
        @php
            $primeiroRegisto = $registos->first();
            $quantidadeParcelas = $registos->count();
            $valorTotal = $registos->sum('valorDescricao');
            $idGrupo = 'pagamento-' . \Illuminate\Support\Str::slug($descricao) . '-' . $loop->index;
        @endphp

        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-start">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                           class="custom-control-input checkbox-pagamento"
                           id="{{ $idGrupo }}"
                           value="{{ $primeiroRegisto->tipo }}"
                           checked>
                    <label class="custom-control-label" for="{{ $idGrupo }}">
                        <strong>{{ $descricao }}</strong><br>
                        <small class="text-muted">
                            <span class="parcelas-selecionadas">{{ $quantidadeParcelas }}</span>
                            de {{ $quantidadeParcelas }} parcelas selecionadas
                        </small>
                    </label>
                </div>

                <div class="text-right ml-3">
                    <span class="badge badge-primary valor-pagamento-selecionado">
                        {{ number_format((float) $valorTotal, 2, ',', '.') }} MT
                    </span>
                    @if ($quantidadeParcelas > 1)
                        <button type="button"
                                class="btn btn-sm btn-link p-0 d-block ml-auto btn-toggle-parcelas"
                                data-target="#parcelas-{{ $idGrupo }}"
                                aria-expanded="false">
                            Ver parcelas <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                    @endif
                </div>
            </div>

            <div id="parcelas-{{ $idGrupo }}"
                 class="pagamento-parcelas-detalhes pl-4 pt-2"
                 @if ($quantidadeParcelas > 1) hidden @endif>
                @foreach ($registos as $index => $item)
                    @php
                        $idParcela = $idGrupo . '-parcela-' . $index;
                        $periodo = '';
                        if ($item->inicio && $item->limite) {
                            $periodo = \Carbon\Carbon::parse($item->inicio)->format('d/m/Y')
                                . ' a '
                                . \Carbon\Carbon::parse($item->limite)->format('d/m/Y');
                        } elseif ($item->limite) {
                            $periodo = 'Vencimento: ' . \Carbon\Carbon::parse($item->limite)->format('d/m/Y');
                        } elseif ($item->inicio) {
                            $periodo = 'Início: ' . \Carbon\Carbon::parse($item->inicio)->format('d/m/Y');
                        }
                    @endphp

                    <div class="custom-control custom-checkbox pagamento-parcela mb-1">
                        <input type="checkbox"
                               class="custom-control-input checkbox-parcela"
                               id="{{ $idParcela }}"
                               data-tipo="{{ $primeiroRegisto->tipo }}"
                               data-mes="{{ $item->mes }}"
                               data-valor="{{ (float) $item->valorDescricao }}"
                               checked>
                        <label class="custom-control-label" for="{{ $idParcela }}">
                            {{ $item->mesNome ?: 'Parcela ' . ($index + 1) }}
                            <span class="text-muted ml-1">
                                {{ number_format((float) $item->valorDescricao, 2, ',', '.') }} MT
                            </span>
                            @if ($periodo)
                                <small class="d-block text-muted">{{ $periodo }}</small>
                            @endif
                        </label>
                    </div>
                @endforeach
            </div>
        </li>
    @empty
        <li class="list-group-item text-center text-muted pagamento-vazio">
            <i class="fas fa-info-circle fa-2x mb-2"></i><br>
            Nenhum pagamento configurado para esta classe e ano lectivo.
        </li>
    @endforelse
</ul>
</div>

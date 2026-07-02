<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>

    <!-- Bootstrap CSS (via CDN) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>

        .card-ele {
            display: none; /* Esconde as divs inicialmente */
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <select class="form-control mb-4" id="tipoSelect">
        <optgroup>
            @foreach ($mesepagamento->unique('anomdelo_id') as $dede)
                <option value="{{ $dede->DescricaoTipo }}">
                    {{ $dede->DescricaoTipo }}
                </option>
            @endforeach
        </optgroup>
    </select>

    @foreach ($mesepagamento->unique('anomdelo_id') as $dede)
        <div class="card card-ele mb-4" data-tipo="{{ $dede->DescricaoTipo }}">
            <div class="card-header">
                {{ $dede->DescricaoTipo }}
            </div>
            <div class="card-body">
                @if ($dede->anomdelo_id == 1)
                    <label for="DataFimGeericas">Data Fim Genéricas</label>
                    <input type="number" min="1" max="28" value="10" name="DataFimGeericas" id="DataFimGeericas" class="form-control" />
                @endif

                <ul>
                    @foreach ($mesepagamento->where("DescricaoTipo", $dede->DescricaoTipo) as $itemselec)
                        <li>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="item{{ $itemselec->id }}" value="{{ $itemselec->id }}" name="items[]">
                                <label class="form-check-label" for="item{{ $itemselec->id }}">
                                    {{ $itemselec->Descricao }}
                                </label>
                            </div>

                            @if ($itemselec->anomdelo_id != 1)
                                <div>
                                    <label for="DataInicio{{ $itemselec->id }}">Data Início</label>
                                    <input type="date" name="DataInicio[{{ $itemselec->id }}]" id="DataInicio{{ $itemselec->id }}" class="form-control" />

                                    <label for="DataFim{{ $itemselec->id }}">Data Fim</label>
                                    <input type="date" name="DataFim[{{ $itemselec->id }}]" id="DataFim{{ $itemselec->id }}" class="form-control" />
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectElement = document.getElementById('tipoSelect');
        const cards = document.querySelectorAll('.card-ele');

        // Função para exibir a div correspondente e esconder as outras
        selectElement.addEventListener('change', function () {
            const selectedValue = this.value;

            cards.forEach(card => {
                if (card.getAttribute('data-tipo') === selectedValue) {
                    card.style.display = 'block'; // Mostra a div selecionada
                } else {
                    card.style.display = 'none'; // Esconde as outras divs
                }
            });
        });

        // Exibe a primeira div ao carregar a página
        if (selectElement.value) {
            selectElement.dispatchEvent(new Event('change'));
        }
    });
</script>

</body>
</html>

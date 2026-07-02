<!-- Main content -->
@php
$request =Request();
    $host = $request->getHost();

    $subdomain = explode('.', $host)[0];


@endphp
<div class="content container-fluid" id="content">
    <div class="container-fluid">
        <!-- Card do Aluno - Melhorado -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-gradient rounded-circle p-3 me-3">
                                <i class="fas fa-user-graduate text-white fa-2x"></i>
                            </div>
                            <h3 class="fw-bold">Situação de {{ $Valores_pago[0]->tipoPagamento }}</h3>
                        </div>
   <!-- Foto do Aluno -->
              <div class="row g-3">
               <div class="photo-container col-md-3 d-flex justify-content-center">

    <div style="width:130px; height:130px;  border-radius: 50%;" class="overflow-hidden">

        @if(!empty($aluno->avatar))
            <img src="{{ asset('storage/' . $subdomain . '/fotoAluno/' . $aluno->avatar) }}" style="  border-radius: 50%;"
                 alt="Foto do aluno"
                 class="w-100 h-100"
                 {{-- style="object-fit: cover;" --}}
                 >
        @else
            <div class="d-flex align-items-center justify-content-center w-100 h-100 bg-light text-center small">
                FOTOGRAFIA<br>
                (3,5 x 4,5 cm)
            </div>
        @endif

    </div>

</div>


                            <div class="col-md-6 col-lg-4">
                                <div class="d-flex border-bottom pb-2 row">
                                    <span class="fw-bold text-secondary col-md-6" style="min-width: 120px;">Nome do Aluno:</span>
                                    <span class="ms-2 col-md-6">{{ $aluno->nome }}</span>
                                </div>


                                <div class="d-flex border-bottom pb-2 row">
                                    <span class="fw-bold text-secondary col-md-6" style="min-width: 120px;">Sexo:</span>
                                    <span class="ms-2 col-md-6">
                                        @if($aluno->sexo == 'M')
                                            <i class="fas fa-mars text-primary me-1"></i>Masculino
                                        @else
                                            <i class="fas fa-venus text-danger me-1"></i>Feminino
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <!-- Adicione mais campos conforme necessário -->
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Título da Situação - Melhorado -->
        {{-- <div class="text-center mb-4">
            <div class="d-inline-block bg-light rounded-3 px-5 py-3 shadow-sm">
                <h3 class="mb-0">
                    <i class="fas fa-chart-line text-primary me-2"></i>

                </h3>
            </div>
        </div> --}}

        <!-- Tabela - Melhorada -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-primary bg-gradient text-white">
                            <tr>
                                <th class="py-3 px-4">{{$Valores_pago[0]->tipodepagamentoDescricao}}</th>
                                <th class="py-3">Estado</th>
                                <th class="py-3">Multa</th>
                                <th class="py-3">Taxa Mensal</th>
                                <th class="py-3">Total</th>
                                <th class="py-3 text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $AnualMulta = 0;
                            $Anual = 0;
                            ?>

                            @foreach($Valores_pago as $Valores_pagoItem)
                                <?php
                                $valormensal = 0;
                                $valorMulta = 0;

                                if($Valores_pagoItem->Estados == "Pago"):
                                    $valores = DB::table("tabelavaloresano")
                                        ->where("Finalidade", $Valores_pagoItem->tipoPagamento)
                                        ->where("idanolectivo", $Valores_pagoItem->anolectivo_id)
                                        ->where("classId", $Valores_pagoItem->classe_id)
                                        ->first();
                                    $valormensal = $valores->valorDescricao;
                                    $valorMulta = $Valores_pagoItem->Multa;

                                    $AnualMulta = $valorMulta + $AnualMulta;
                                    $Anual = $valormensal + $Anual;
                                endif
                                ?>
                                <tr>
                                    <td class="px-4 py-3">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        {{ $Valores_pagoItem->mes }}
                                    </td>
                                    <td class="py-3">
                                        @if($Valores_pagoItem->Estados == 'Pago')
                                            <span class="badge bg-success bg-gradient px-3 py-2 rounded-pill">
                                                <i class="fas fa-check-circle me-1"></i>Pago
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-gradient px-3 py-2 rounded-pill">
                                                <i class="fas fa-clock me-1"></i>Pendente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <span class="text-danger fw-bold">{{ number_format($valorMulta, 2, ',', '.') }} MT</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-success fw-bold">{{ number_format($valormensal, 2, ',', '.') }} MT</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-primary">{{ number_format($valorMulta + $valormensal, 2, ',', '.') }} MT</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        @if($Valores_pagoItem->Estados == 'Pago')
                                            <button class="btn btn-sm btn-info imprimir-linha"
                                                    data-mes="{{ $Valores_pagoItem->mes_id }}"
                                                    data-aluno-id="{{ $aluno->Aluno_classe_id }}"
                                                    data-aluno-recibo="{{ $Valores_pagoItem->Ntalao }}"
                                                    data-tipo-id="{{ $Valores_pagoItem->tipoPagamento_id }}"
                                                    data-metodo-id="{{ $Valores_pagoItem->metodo_pagamento_id }}"
                                                    data-anolectivo-id="{{ $Valores_pagoItem->anolectivo_id }}"
                                                    title="Imprimir Recibo {{ $Valores_pagoItem->Ntalao }}">
                                                <i class="fas fa-print me-1"></i>
                                                Recibo #{{ $Valores_pagoItem->Ntalao }}
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light fw-bold">
                            <tr>
                                <th colspan="2" class="px-4 py-3 text-end">Totais:</th>
                                <th class="py-3 text-danger">{{ number_format($AnualMulta, 2, ',', '.') }} MT</th>
                                <th class="py-3 text-success">{{ number_format($Anual, 2, ',', '.') }} MT</th>
                                <th class="py-3 text-primary">{{ number_format($AnualMulta + $Anual, 2, ',', '.') }} MT</th>
                                <th class="py-3"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <input name="IdClasseAluno" value="{{ $aluno->Aluno_classe_id }}" type="hidden">
    </div>
</div>

<!-- Botões de Ação - Melhorados -->
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-end gap-3">
        {{-- <a href="/RegistoAcademico/outrosPagamento/imprimir/{{ $aluno->Aluno_classe_id }}/{{ $Valores_pago[0]->tipoPagamento_id }}/1"
           class="btn btn-primary btn-lg shadow-sm">
           <i class="fas fa-file-pdf me-2"></i> Baixar PDF
        </a> --}}

        <button class="btn btn-success btn-lg shadow-sm buttonImprimir"
                idtipo="{{ $Valores_pago[0]->tipoPagamento_id }}"
                title="{{ $aluno->Aluno_classe_id }}">
            <i class="fas fa-print me-2"></i> Imprimir Tudo
        </button>
    </div>
</div>

<!-- Adicione este CSS para melhorar ainda mais -->
<style>
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid rgba(255,255,255,0.1);
    }

    .table tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05) !important;
        transition: background-color 0.2s ease;
    }

    .btn-imprimir-linha {
        white-space: nowrap;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .table-responsive {
        border-radius: 12px;
    }
</style>

<script>
$(document).ready(function() {
    // Função para imprimir tudo
    $(".buttonImprimir").click(function() {
        var $id = $(this).attr("title");
        var $idtipo = $(this).attr("idtipo");
        const url = "/RegistoAcademico/outrosPagamento/imprimir/" + $id + "/" + $idtipo + "/1";
        abrirReciboPDF(url, $id,null);
    });

    // Função para imprimir linha específica
    $(".imprimir-linha").click(function() {
        var alunoId = $(this).data('aluno-id');
        var tipoId = $(this).data('tipo-id');
        var talao = $(this).data('aluno-recibo');
        var metodo = $(this).data('metodo-id');
        var anolectivoid = $(this).data('anolectivo-id');
        var mes = $(this).data('mes');

        flag = null;
        const urlRecibo = `${imprimirRecibo}${anolectivoid}/${alunoId}/${talao}/${metodo}/${flag}`;
        abrirReciboPDF(urlRecibo, alunoId,metodo);
    });
});
</script>

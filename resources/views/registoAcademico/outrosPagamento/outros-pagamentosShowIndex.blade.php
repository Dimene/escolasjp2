@extends('layouts.admin-Lti')
@section('title', 'Outros Pagamentos')

<style>
      .card-custom {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    background-color: #fff;
    margin-bottom: 20px;
}
/* VALIDAÇÃO */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .is-valid {
            border-color: #28a745 !important;
        }
.input-error {
    border: 2px solid #dc3545 !important;
}

.input-success {
    border: 2px solid #28a745 !important;
}




        .status-referencia.valida {
            color: #28a745;
            display: block;
        }

        .status-referencia.invalida {
            color: #dc3545;
            display: block;
        }


         /* Popup PDF */
.pdf-popup {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  z-index: 9999;
  animation: fadeIn 0.3s ease;
}

.pdf-popup-content {
  position: relative;
  margin: 2% auto;
  width: 90%;
  height: 90%;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  animation: slideIn 0.3s ease;
}

.pdf-close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 10000;
  background: #dc3545;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s;
}

.pdf-close-btn:hover {
  background: #c82333;
}

.pdf-controls {
  position: absolute;
  top: 10px;
  left: 10px;
  z-index: 10000;
  display: flex;
  gap: 10px;
}

.pdf-control-btn {
  background: #007bff;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s;
}

.pdf-control-btn:hover {
  background: #0056b3;
}

.pdf-container {
  width: 100%;
  height: 100%;
  padding: 60px 20px 20px 20px;
}

#pdfFrame {
  width: 100%;
  height: 100%;
  border: none;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.pdf-loading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  z-index: 100;
}

.pdf-loading p {
  margin-top: 15px;
  color: #666;
  font-size: 16px;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideIn {
  from { transform: translateY(-30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* Para impressão do popup */
@media print {
  .pdf-popup {
    position: static;
    background: #fff;
  }

  .pdf-popup-content {
    margin: 0;
    width: 100%;
    height: 100%;
    box-shadow: none;
  }

  .pdf-close-btn,
  .pdf-controls {
    display: none !important;
  }

  .pdf-container {
    padding: 0;
  }

  #pdfFrame {
    box-shadow: none;
  }
}
    </style>
    <style>

#listadosalunos_filter { display:none; }
.loading-spinner {
    display: none;
}
.loading .loading-spinner {
    display: inline-block;
}
.referencia-status {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
.referencia-status.valida {
    color: #28a745;
}

.referencia-status.invalida {
    color: #dc3545;
}
</style>


@section('content')

 <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-credit-card"></i>Pagamentos</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-edit"></i> <b>Efetual</b>
            </li>
        </ol>
    </div>
<section class="content">
<div class="">


        <div class="container-fluid">
            <div class="row ">
                <div class="col">
                    <select name="anolectivo_id" class="form-control SELECT_fILTRO " style="height: 33px"  >
                        @foreach ($anolectivo as $anoItem)
                            <option value="{{ $anoItem->id }}"
                                @if (now()->format('Y') == $anoItem->anolectivo) selected @endif >
                                {{ $anoItem->anolectivo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col">
                    <select name="classe_id" class="form-control SELECT_fILTRO" style="height: 33px" >
                        @foreach ($classes as $classesItem)
                            <option value="{{ $classesItem->id }}">
                                {{ $classesItem->Descricao }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="cabecalhoDados Conteudopagamentos"></div>

            <div class=" Conteudopagamentospagar border-0 shadow-sm" style="display: none">
                <div class=" bg-white border-bottom d-flex align-items-centercard-custom ">
                    <button class="btn btn-outline-primary Voltarao_menumpagamentos ">
                        <i class="fa fa-arrow-left me-2"></i> Voltar
                    </button>
                    <h5 class="mb-2 flex-grow-1 text-center text-muted">Gerenciamento de Pagamentos</h5>
                </div>
                <div class="ConteudoPagarDados" style=""></div>
            </div>
        </div>
    </div>
</div>


<!-- Popup para PDF -->
<div id="pdfPopup" class="pdf-popup">
  <div class="pdf-popup-content">
    <!-- Botão de fechar -->
    <button id="closeBtn" class="pdf-close-btn">
      <i class="fas fa-times"></i> Fechar
    </button>

    <!-- Botões de controle -->
    <div class="pdf-controls">
      <button id="printBtn" class="pdf-control-btn">
        <i class="fas fa-print"></i> Imprimir
      </button>
      <button id="downloadBtn" class="pdf-control-btn">
        <i class="fas fa-download"></i> Baixar
      </button>
    </div>

    <!-- Container do PDF -->
    <div class="pdf-container">
      <iframe id="pdfFrame" frameborder="0"></iframe>
    </div>

    <!-- Loading -->
    <div id="pdfLoading" class="pdf-loading">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando PDF...</span>
      </div>
      <p>Carregando recibo...</p>
    </div>
  </div>
</div>
</section>


@push("script")
<!-- jQuery (obrigatório - DataTables depende dele) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap 5 JS (opcional, para componentes interativos) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables Core (obrigatório) -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons Extension (obrigatório para os botões) -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>

<!-- Bibliotecas de exportação (obrigatórias para os botões Copy, Excel, PDF, Print) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<!-- DataTables Buttons Bootstrap 5 (opcional - para estilização) -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>

<!-- SweetAlert2 (para alertas bonitos) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    // rota gerada pelo Laravel, com placeholders
    let payrShow = "{{ route('outrosPagamento.payrShow', [':idaluno', ':idmes', ':tipopagamento', ':flag']) }}";
    let mostrarestadodasparcelas = "{{ route('outrosPagamento.mostraasmensalidadesDotipo', [':idaluno', ':tipo',':flag']) }}";
    let atualizarPagamento = "{{ route('mensalida.atualizar', [':idaluno']) }}";

    // string simples para a URL
    let validarReferenciaUrl = "/aluno/matricula/validarReferencia/";
    let imprimirRecibo = "/aluno/matricula/imprimir/recibo/";
$token="{{ csrf_token() }}";

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('Admin-LTE/plugins/sweetalert2/sweetalert2@11.js') }}"></script>
    {{-- <script src="{{ asset('Admin-LTE/plugins/sweetalert2/sweetalert2.js') }}"></script> --}}
    <script src="{{ asset('MyJs/imprimirRecibo.js') }}"></script>
<script  src="{{ asset('js/components/OutrosPagamentos.js') }}">


</script>
@endpush
@endsection

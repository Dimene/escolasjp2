<!-- Popup para Visualização de PDF -->
<div id="pdfPopup" class="pdf-popup">
    <div class="pdf-popup-content">
        <!-- Botão de fechar -->
        <button class="pdf-close-btn" onclick="window.PagamentoModule.fecharPopupPDF()">
            <i class="fas fa-times"></i> Fechar
        </button>

        <!-- Botões de controle -->
        <div class="pdf-controls">
            <button class="pdf-control-btn" onclick="window.PagamentoModule.imprimirPopupPDF()">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <button class="pdf-control-btn" onclick="window.PagamentoModule.baixarPopupPDF()">
                <i class="fas fa-download"></i> Baixar
            </button>
        </div>

        <!-- Container do PDF -->
        <div class="pdf-container">
            <iframe id="pdfFrame" frameborder="0"></iframe>
        </div>

        <!-- Loading -->
        <div id="pdfLoading" class="pdf-loading" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Carregando PDF...</span>
            </div>
            <p class="mt-2">Carregando recibo...</p>
        </div>
    </div>
</div>

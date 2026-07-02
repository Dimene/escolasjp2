// Função para abrir o PDF (com Swal.fire interno)
function abrirReciboPDF(url, idaluno, metodo = null) {
    console.log('URL do PDF:', url);

    // MOSTRA LOADING AQUI (dentro da função)
    Swal.fire({
        title: 'A processar...',
        text: 'Por favor, aguarde.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Verifica se os elementos existem
    const popup = document.getElementById('pdfPopup');
    const loading = document.getElementById('pdfLoading');
    const pdfFrame = document.getElementById('pdfFrame');

    // Se os elementos não existirem, abre em nova aba como fallback
    if (!popup || !loading || !pdfFrame) {
        console.warn('Elementos do popup não encontrados, abrindo em nova aba');
        Swal.close(); // Fecha o loading
        window.open(url, '_blank');
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: 'Referência gerada com sucesso.',
            timer: 2000,
            showConfirmButton: false
        });
        return;
    }

    // Mostra popup
    popup.style.display = 'block';
    loading.style.display = 'block';
    loading.innerHTML = `
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
        <p>Carregando referência bancária...</p>
    `;
    pdfFrame.style.display = 'none';

    // Faz a requisição do PDF
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/pdf'
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`Erro ${res.status}: ${res.statusText}`);
        }
        return res.blob();
    })
    .then(blob => {
        // FECHA O SWAL.LOADING quando o PDF carregar
        Swal.close();

        // Remove URL anterior se existir
        if (pdfFrame.src && pdfFrame.src.startsWith('blob:')) {
            URL.revokeObjectURL(pdfFrame.src);
        }

        // Cria URL do blob
        const pdfUrl = URL.createObjectURL(blob);

        // Configura o iframe
        pdfFrame.src = pdfUrl;
        loading.style.display = 'none';
        pdfFrame.style.display = 'block';

        // Configura o botão de download
        const downloadBtn = document.getElementById('downloadBtn');
        if (downloadBtn) {
            const newDownloadBtn = downloadBtn.cloneNode(true);
            downloadBtn.parentNode.replaceChild(newDownloadBtn, downloadBtn);

            newDownloadBtn.onclick = function() {
                const link = document.createElement('a');
                link.href = pdfUrl;
                link.download = `referencia-${idaluno}.pdf`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                Swal.fire({
                    icon: 'success',
                    title: 'Download iniciado!',
                    text: 'O arquivo será baixado em instantes.',
                    timer: 1500,
                    showConfirmButton: false
                });
            };
        }

        // Mostra mensagem de sucesso
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: 'Referência gerada com sucesso.',
            timer: 2000,
            showConfirmButton: false
        });

        // Configura impressão automática se necessário
        if (metodo !== 2) {
            setTimeout(() => {
                try {
                    const iframeWindow = pdfFrame.contentWindow;
                    if (iframeWindow) {
                        iframeWindow.focus();
                        iframeWindow.print();
                    }
                } catch (e) {
                    console.warn('Não foi possível imprimir automaticamente:', e);
                }
            }, 1000);
        }
    })
    .catch(err => {
        console.error('Falha ao carregar o PDF:', err);

        // FECHA O SWAL.LOADING em caso de erro
        Swal.close();

        // Esconde loading e mostra erro no popup
        loading.innerHTML = `
            <div class="alert alert-danger" style="margin: 20px;">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <h4>Erro ao carregar referência</h4>
                <p>${err.message}</p>
                <button onclick="fecharPopupPDF()" class="btn btn-sm btn-danger mt-2">
                    <i class="fas fa-times"></i> Fechar
                </button>
            </div>
        `;

        // Mostra erro
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'Erro ao gerar a referência bancária. Tente novamente.',
            confirmButtonText: 'OK'
        });
    });
}

// Função auxiliar para fechar o popup
function fecharPopupPDF() {
    const popup = document.getElementById('pdfPopup');
    const pdfFrame = document.getElementById('pdfFrame');

    if (popup) {
        popup.style.display = 'none';
    }

    if (pdfFrame && pdfFrame.src && pdfFrame.src.startsWith('blob:')) {
        URL.revokeObjectURL(pdfFrame.src);
        pdfFrame.src = '';
    }
}



// Event Listeners para o popup
document.addEventListener('DOMContentLoaded', function() {
    // Botão fechar
    const closeBtn = document.getElementById('closeBtn');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            fecharPopupPDF();
        });
    }

    // Botão imprimir
    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            const pdfFrame = document.getElementById('pdfFrame');
            if (pdfFrame && pdfFrame.contentWindow) {
                try {
                    pdfFrame.contentWindow.focus();
                    pdfFrame.contentWindow.print();
                } catch (e) {
                    console.warn('Erro ao imprimir:', e);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atenção',
                        text: 'Não foi possível imprimir automaticamente. Use o botão de download e imprima o arquivo.'
                    });
                }
            }
        });
    }

    // Fecha popup ao clicar fora
    const popup = document.getElementById('pdfPopup');
    if (popup) {
        popup.addEventListener('click', function(e) {
            if (e.target === this) {
                fecharPopupPDF();
            }
        });
    }

    // Fecha com tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const popupElement = document.getElementById('pdfPopup');
            if (popupElement && popupElement.style.display === 'block') {
                fecharPopupPDF();
            }
        }
    });
});

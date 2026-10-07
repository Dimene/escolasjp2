
<style>
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

<script>
  // Função para abrir o PDF
function abrirReciboPDF(url,idaluno) {
    // Prepara dados para envio
    // const dados = response.meses.map(e => ({
    //     tipo: e.tipo,
    //     mes: e.mes
    // }));

    //const dadosEncoded = encodeURIComponent(JSON.stringify(dados));

    // Monta a URL
   // const urlRecibo = `${URLS.imprimirRecibo}${response.anolectivo}/${response.idaluno}/${dadosEncoded}/${response.metodo}`;

    console.log('URL do PDF:', url);

    // Mostra loading
    const popup = document.getElementById('pdfPopup');
    const loading = document.getElementById('pdfLoading');
    const pdfFrame = document.getElementById('pdfFrame');

    popup.style.display = 'block';
    loading.style.display = 'block';
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
            throw new Error(`Erro ao buscar o PDF: ${res.status} ${res.statusText}`);
        }
        return res.blob();
    })
    .then(blob => {
        // Cria URL do blob
        const pdfUrl = URL.createObjectURL(blob);

        // Configura o iframe
        pdfFrame.src = pdfUrl;
        loading.style.display = 'none';
        pdfFrame.style.display = 'block';

        // Configura o botão de download
        document.getElementById('downloadBtn').onclick = function() {
            const link = document.createElement('a');
            link.href = pdfUrl;
            link.download = `recibo-matricula-${idaluno}.pdf`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };

        // Configura impressão automática se necessário
        if (response.metodo !== 2) { // Só imprime automaticamente se não for M-Pesa
            setTimeout(() => {
                const iframeWindow = pdfFrame.contentWindow;
                if (iframeWindow) {
                    iframeWindow.focus();
                    iframeWindow.print();
                }
            }, 1000);
        }
    })
    .catch(err => {
        console.error('Falha ao carregar o PDF:', err);
        loading.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <h4>Erro ao carregar recibo</h4>
                <p>${err.message}</p>
                <button onclick="document.getElementById('pdfPopup').style.display='none'"
                        class="btn btn-sm btn-danger">
                    Fechar
                </button>
            </div>
        `;
    });
}
// Fecha popup
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'closeBtn') {
        const popup = document.getElementById('pdfPopup');
        const pdfFrame = document.getElementById('pdfFrame');

        popup.style.display = 'none';
        if (pdfFrame.src) {
            URL.revokeObjectURL(pdfFrame.src);
            pdfFrame.src = '';
        }
    }
});

// Imprimir
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'printBtn') {
        const pdfFrame = document.getElementById('pdfFrame');
        const iframeWindow = pdfFrame.contentWindow;

        if (iframeWindow) {
            iframeWindow.focus();
            iframeWindow.print();
        }
    }
});

// Fecha popup ao clicar fora
document.addEventListener('click', function(e) {
    const popup = document.getElementById('pdfPopup');
    if (popup && e.target === popup) {
        popup.style.display = 'none';
        const pdfFrame = document.getElementById('pdfFrame');
        if (pdfFrame.src) {
            URL.revokeObjectURL(pdfFrame.src);
            pdfFrame.src = '';
        }
    }
});

// Fecha com tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const popup = document.getElementById('pdfPopup');
        if (popup && popup.style.display === 'block') {
            popup.style.display = 'none';
            const pdfFrame = document.getElementById('pdfFrame');
            if (pdfFrame.src) {
                URL.revokeObjectURL(pdfFrame.src);
                pdfFrame.src = '';
            }
        }
    }
});
</script>

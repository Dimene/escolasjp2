<style>
/* ============================================================
   POPUP DE DOCUMENTO
   ============================================================ */
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
  flex-wrap: wrap;
}

.pdf-control-btn {
  background: #007bff;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s, opacity 0.3s;
}

.pdf-control-btn:hover  { background: #0056b3; }
.pdf-control-btn:disabled {
  opacity: .6;
  cursor: not-allowed;
}

.pdf-control-btn.btn-copy    { background: #6c757d; }
.pdf-control-btn.btn-copy:hover { background: #5a6268; }

.pdf-control-btn.btn-copy.copiado { background: #198754 !important; }
.pdf-control-btn.btn-copy.erro    { background: #dc3545 !important; }

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
  to   { opacity: 1; }
}

@keyframes slideIn {
  from { transform: translateY(-30px); opacity: 0; }
  to   { transform: translateY(0);     opacity: 1; }
}

/* Impressão direta da página (fallback) */
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
  .pdf-container { padding: 0; }
  #pdfFrame      { box-shadow: none; }
}
</style>

<!-- ============================================================
     POPUP DE DOCUMENTO
     ============================================================ -->
<div id="pdfPopup" class="pdf-popup">
  <div class="pdf-popup-content">

    <!-- Fechar -->
    <button id="closeBtn" class="pdf-close-btn">
      <i class="fas fa-times"></i> Fechar
    </button>

    <!-- Controles -->
    <div class="pdf-controls">
      <button id="printBtn" class="pdf-control-btn">
        <i class="fas fa-print"></i> Imprimir
      </button>
      <button id="downloadBtn" class="pdf-control-btn">
        <i class="fas fa-download"></i> Baixar
      </button>
      <button id="copyBtn" class="pdf-control-btn btn-copy">
        <i class="fas fa-copy"></i> Copiar
      </button>
    </div>

    <!-- Container -->
    <div class="pdf-container">
      <iframe id="pdfFrame" frameborder="0"></iframe>
    </div>

    <!-- Loading -->
    <div id="pdfLoading" class="pdf-loading">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando documento...</span>
      </div>
      <p>Carregando documento...</p>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
/* ============================================================
   ESTADO GLOBAL DO POPUP (guardamos o que está aberto)
   ============================================================ */
window.__docState = {
    blob:          null,   // Blob do documento
    blobUrl:       null,   // URL.createObjectURL ativa
    mime:          '',     // Ex: application/pdf, image/png
    ext:           '',     // Extensão do arquivo
    filename:      '',     // Nome final para download
    isPDF:         false,
    isImage:       false,
    isHTML:        false,
    textoParaCopiar: ''    // Texto puro do documento (para Copiar)
};

/* ------------------------------------------------------------
   Mapeia MIME → extensão
   ------------------------------------------------------------ */
function getExtensaoPorMime(mime) {
    if (!mime) return 'bin';
    mime = mime.toLowerCase();

    const mapa = {
        'application/pdf': 'pdf',
        'image/png': 'png',
        'image/jpeg': 'jpg',
        'image/jpg': 'jpg',
        'image/gif': 'gif',
        'image/webp': 'webp',
        'image/svg+xml': 'svg',
        'image/bmp': 'bmp',
        'text/html': 'html',
        'text/plain': 'txt',
        'text/csv': 'csv',
        'application/msword': 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 'docx',
        'application/vnd.ms-excel': 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': 'xlsx',
        'application/zip': 'zip',
        'application/json': 'json',
        'application/xml': 'xml',
        'text/xml': 'xml'
    };

    if (mapa[mime]) return mapa[mime];
    if (mime.startsWith('image/')) return mime.split('/')[1];
    if (mime.startsWith('text/'))  return 'txt';
    return 'bin';
}

/* ------------------------------------------------------------
   Limpa o estado (chamado ao fechar)
   ------------------------------------------------------------ */
function limparEstadoDoc() {
    const s = window.__docState;
    if (s.blobUrl) {
        try { URL.revokeObjectURL(s.blobUrl); } catch (e) {}
    }
    window.__docState = {
        blob: null, blobUrl: null, mime: '', ext: '',
        filename: '', isPDF: false, isImage: false,
        isHTML: false, textoParaCopiar: ''
    };
}

/* ------------------------------------------------------------
   Fecha o popup
   ------------------------------------------------------------ */
function fecharPopup() {
    const popup = document.getElementById('pdfPopup');
    const pdfFrame = document.getElementById('pdfFrame');

    popup.style.display = 'none';
    if (pdfFrame) {
        pdfFrame.src = 'about:blank';
        pdfFrame.style.display = 'none';
    }
    limparEstadoDoc();
}

/* ============================================================
   ABRIR DOCUMENTO NO POPUP (funciona com QUALQUER tipo)
   ============================================================ */
function abrirReciboPDF(url, idaluno) {
    console.log('URL do documento:', url);

    const popup     = document.getElementById('pdfPopup');
    const loading   = document.getElementById('pdfLoading');
    const pdfFrame  = document.getElementById('pdfFrame');
    const copyBtn   = document.getElementById('copyBtn');

    // Reset visual
    popup.style.display = 'block';
    loading.style.display = 'block';
    loading.innerHTML = `
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando documento...</span>
        </div>
        <p>Carregando documento...</p>
    `;
    pdfFrame.style.display = 'none';

    // Reset botão copiar
    copyBtn.classList.remove('copiado', 'erro');
    copyBtn.innerHTML = '<i class="fas fa-copy"></i> Copiar';

    // Limpa estado anterior
    limparEstadoDoc();

    fetch(url, { method: 'GET', headers: { 'Accept': '*/*' } })
    .then(res => {
        if (!res.ok) {
            throw new Error(`Erro ao buscar o documento: ${res.status} ${res.statusText}`);
        }

        const contentType  = res.headers.get('Content-Type') || '';
        const disposition  = res.headers.get('Content-Disposition') || '';

        let nomeArquivoHeader = null;
        const match = disposition.match(/filename\*?=(?:UTF-8'')?["']?([^;"']+)/i);
        if (match && match[1]) nomeArquivoHeader = decodeURIComponent(match[1]);

        return res.blob().then(blob => ({
            blob,
            contentType: contentType.split(';')[0].trim() || blob.type || '',
            nomeArquivoHeader
        }));
    })
    .then(async ({ blob, contentType, nomeArquivoHeader }) => {
        const blobUrl = URL.createObjectURL(blob);
        const mime    = contentType || blob.type || '';
        const ext     = getExtensaoPorMime(mime);

        const isPDF   = mime === 'application/pdf';
        const isImage = mime.startsWith('image/');
        const isHTML  = mime === 'text/html';
        const isText  = mime.startsWith('text/');

        // Guarda estado global
        const s = window.__docState;
        s.blob     = blob;
        s.blobUrl  = blobUrl;
        s.mime     = mime;
        s.ext      = ext;
        s.isPDF    = isPDF;
        s.isImage  = isImage;
        s.isHTML   = isHTML;

        const nomeBase = nomeArquivoHeader
            ? nomeArquivoHeader.replace(/\.[^.]+$/, '')
            : `documento-${idaluno || 'baixado'}`;
        s.filename = `${nomeBase}.${ext}`;

        // ---------- Configura o iframe conforme tipo ----------
        if (isPDF) {
            pdfFrame.src = blobUrl;
            pdfFrame.style.display = 'block';

        } else if (isImage) {
            pdfFrame.src = 'data:text/html;charset=utf-8,' + encodeURIComponent(`
                <html><head><style>
                    body { margin:0; background:#f0f0f0; display:flex;
                           align-items:center; justify-content:center;
                           height:100vh; }
                    img { max-width:100%; max-height:100%;
                          box-shadow:0 2px 20px rgba(0,0,0,.2); }
                </style></head>
                <body><img src="${blobUrl}" alt="Documento"></body></html>
            `);
            pdfFrame.style.display = 'block';

        } else if (isHTML) {
            pdfFrame.src = blobUrl;
            pdfFrame.style.display = 'block';

        } else if (isText) {
            const texto = await blob.text();
            s.textoParaCopiar = texto;
            pdfFrame.src = 'data:text/html;charset=utf-8,' + encodeURIComponent(`
                <html><head><style>
                    body { font-family: monospace; padding:20px;
                           background:#fff; color:#333; white-space:pre-wrap; }
                </style></head>
                <body>${texto.replace(/[<>]/g, c => ({'<':'&lt;','>':'&gt;'}[c]))}</body></html>
            `);
            pdfFrame.style.display = 'block';

        } else {
            // DOCX, XLSX, ZIP, bin...
            pdfFrame.src = 'data:text/html;charset=utf-8,' + encodeURIComponent(`
                <html><head><style>
                    body { font-family: Arial, sans-serif; display:flex;
                           align-items:center; justify-content:center;
                           height:100vh; margin:0; background:#f8f9fa; }
                    .box { text-align:center; padding:40px; background:#fff;
                           border-radius:10px; box-shadow:0 4px 20px rgba(0,0,0,.08); }
                    i { font-size:48px; color:#6c757d; margin-bottom:15px; }
                    p { color:#495057; margin:10px 0; }
                    b { color:#0d6efd; }
                </style></head>
                <body><div class="box">
                    <i>📄</i>
                    <h3>Documento não pré-visualizável</h3>
                    <p>Tipo: <b>${mime || 'desconhecido'}</b></p>
                    <p>Clique em <b>Baixar</b> para salvar o arquivo.</p>
                </div></body></html>
            `);
            pdfFrame.style.display = 'block';
        }

        loading.style.display = 'none';

        // ---------- Guarda texto para o botão Copiar ----------
        if (isPDF) {
            // PDF: não conseguimos extrair texto sem PDF.js.
            // Vamos guardar o nome/URL para o Copiar dar um feedback útil.
            s.textoParaCopiar = `Documento PDF: ${s.filename}\nOrigem: ${url}`;
        } else if (!isText && !isHTML && !isImage) {
            s.textoParaCopiar = `Documento: ${s.filename}\nTipo: ${mime || 'desconhecido'}\nOrigem: ${url}`;
        }

        // ---------- Impressão automática (só PDF) ----------
        if (isPDF) {
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
        console.error('Falha ao carregar documento:', err);
        loading.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <h4>Erro ao carregar documento</h4>
                <p>${err.message}</p>
                <button onclick="fecharPopup()" class="btn btn-sm btn-danger">
                    Fechar
                </button>
            </div>
        `;
    });
}

/* ============================================================
   BOTÃO IMPRIMIR
   ============================================================ */
document.getElementById('printBtn').addEventListener('click', function () {
    const pdfFrame = document.getElementById('pdfFrame');
    const s = window.__docState;

    if (!s.blob) {
        alert('Nenhum documento carregado.');
        return;
    }

    if (s.isPDF || s.isImage || s.isHTML || s.mime.startsWith('text/')) {
        // PDF / imagem / html / texto → imprime direto do iframe
        const iframeWindow = pdfFrame.contentWindow;
        if (iframeWindow) {
            iframeWindow.focus();
            iframeWindow.print();
        }
    } else {
        // Tipos não imprimíveis → avisa
        alert('Este tipo de documento (' + s.mime + ') não pode ser impresso diretamente. Baixe-o e abra no programa adequado.');
    }
});

/* ============================================================
   BOTÃO BAIXAR — sempre gera PDF
   ============================================================ */

document.getElementById('downloadBtn').addEventListener('click', async function () {

    const btn = this;
    const original = btn.innerHTML;
    const s = window.__docState;

    if (!s.blob) {
        alert('Nenhum documento carregado para baixar.');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Baixando...';

    try {

        /*
        |--------------------------------------------------------------------------
        | 1. PDF
        |--------------------------------------------------------------------------
        | Se o servidor já devolveu PDF, simplesmente baixamos o PDF.
        */
        if (s.isPDF) {

            const link = document.createElement('a');

            link.href = s.blobUrl;

            link.download = s.filename || 'documento.pdf';

            document.body.appendChild(link);

            link.click();

            document.body.removeChild(link);

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 2. IMAGEM
        |--------------------------------------------------------------------------
        | Mantém a conversão da imagem para PDF.
        */
        if (s.isImage) {

            const nomePDF =
                (s.filename || 'documento')
                .replace(/\.[^.]+$/, '') + '.pdf';


            const wrapper = document.createElement('div');

            wrapper.style.width = '100%';
            wrapper.style.padding = '10px';
            wrapper.style.background = '#fff';
            wrapper.style.textAlign = 'center';


            const img = document.createElement('img');

            img.src = s.blobUrl;

            img.style.maxWidth = '100%';
            img.style.height = 'auto';


            wrapper.appendChild(img);

            document.body.appendChild(wrapper);


            await html2pdf()
                .set({
                    margin: 10,
                    filename: nomePDF,

                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },

                    html2canvas: {
                        scale: 2,
                        useCORS: true,
                        backgroundColor: '#ffffff'
                    },

                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                })
                .from(wrapper)
                .save();


            document.body.removeChild(wrapper);

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 3. HTML
        |--------------------------------------------------------------------------
        | IMPORTANTE:
        | Não usamos innerHTML do iframe.
        |
        | Clonamos o documento renderizado e baixamos o conteúdo visual.
        |--------------------------------------------------------------------------
        */

        if (s.isHTML) {

            const iframe = document.getElementById('pdfFrame');

            const iframeDoc =
                iframe.contentDocument ||
                iframe.contentWindow.document;


            if (!iframeDoc || !iframeDoc.body) {

                throw new Error(
                    'Não foi possível obter os dados do documento.'
                );

            }


            /*
            | Cria uma cópia completa da página.
            */
            const clone = iframeDoc.documentElement.cloneNode(true);


            /*
            | Cria um iframe temporário para renderização.
            */
            const tempFrame = document.createElement('iframe');

            tempFrame.style.position = 'fixed';
            tempFrame.style.left = '-10000px';
            tempFrame.style.top = '0';

            tempFrame.style.width = '794px';
            tempFrame.style.height = '1123px';

            tempFrame.style.border = 'none';

            document.body.appendChild(tempFrame);


            const tempDoc =
                tempFrame.contentDocument ||
                tempFrame.contentWindow.document;


            tempDoc.open();

            tempDoc.write(
                '<!DOCTYPE html>' +
                clone.outerHTML
            );

            tempDoc.close();


            /*
            | Aguarda imagens/fontes carregarem.
            */
            await new Promise(resolve => {

                setTimeout(resolve, 500);

            });


            const nomePDF =
                (s.filename || 'documento')
                .replace(/\.[^.]+$/, '') + '.pdf';


            /*
            | Gera o PDF usando o documento VISUAL.
            */
            await html2pdf()
                .set({

                    margin: [10, 10, 10, 10],

                    filename: nomePDF,

                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },

                    html2canvas: {

                        scale: 2,

                        useCORS: true,

                        allowTaint: true,

                        backgroundColor: '#ffffff',

                        logging: false

                    },

                    jsPDF: {

                        unit: 'mm',

                        format: 'a4',

                        orientation: 'portrait'

                    },

                    pagebreak: {

                        mode: [
                            'css',
                            'legacy'
                        ]

                    }

                })
                .from(tempDoc.body)
                .save();


            document.body.removeChild(tempFrame);

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 4. TEXTO
        |--------------------------------------------------------------------------
        */
        if (s.mime.startsWith('text/')) {

            const texto =
                s.textoParaCopiar ||
                await s.blob.text();


            const nomePDF =
                (s.filename || 'documento')
                .replace(/\.[^.]+$/, '') + '.pdf';


            const wrapper =
                document.createElement('div');


            wrapper.style.padding = '20px';

            wrapper.style.background = '#fff';

            wrapper.style.fontFamily =
                'Arial, sans-serif';

            wrapper.style.fontSize =
                '12px';


            const pre =
                document.createElement('pre');


            pre.style.whiteSpace =
                'pre-wrap';

            pre.textContent =
                texto;


            wrapper.appendChild(pre);


            document.body.appendChild(wrapper);


            await html2pdf()
                .set({

                    margin: 10,

                    filename: nomePDF,

                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },

                    html2canvas: {
                        scale: 2,
                        backgroundColor: '#fff'
                    },

                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    }

                })
                .from(wrapper)
                .save();


            document.body.removeChild(wrapper);

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 5. OUTROS FORMATOS
        |--------------------------------------------------------------------------
        */
        alert(
            'Este tipo de documento (' +
            (s.mime || 'desconhecido') +
            ') não pode ser convertido para PDF diretamente no navegador.'
        );


    } catch (err) {

        console.error(
            'Erro ao baixar documento:',
            err
        );

        alert(
            'Erro ao gerar o documento: ' +
            err.message
        );

    } finally {

        btn.disabled = false;

        btn.innerHTML = original;

    }

});

/* ============================================================
   BOTÃO COPIAR — copia o que está aberto no popup
   ------------------------------------------------------------
   - Para PDF: não dá pra extrair texto sem PDF.js;
     então copiamos o NOME + URL do arquivo.
   - Para imagem: copiamos a própria imagem (HTML) se o browser suportar.
   - Para HTML: copiamos o HTML renderizado (rich text).
   - Para texto: copiamos o texto.
   - Outros: copiamos um resumo (nome + tipo + origem).
   ============================================================ */
document.getElementById('copyBtn').addEventListener('click', async function () {
    const btn = this;
    const original = btn.innerHTML;
    const s = window.__docState;

    if (!s.blob) {
        alert('Nenhum documento carregado para copiar.');
        return;
    }

    try {
        let html  = '';
        let texto = '';

        if (s.isImage) {
            // Copia a imagem como HTML (colável em editores ricos)
            html  = `<img src="${s.blobUrl}" alt="${s.filename}" style="max-width:100%">`;
            texto = s.filename;
        }
        else if (s.isHTML) {
            // Copia o HTML renderizado do iframe
            try {
                const doc = document.getElementById('pdfFrame').contentDocument;
                html  = '<meta charset="utf-8">' + (doc.body ? doc.body.innerHTML : '');
                texto = doc.body ? doc.body.innerText : '';
            } catch (e) {
                html  = `<p>${s.filename}</p>`;
                texto = s.filename;
            }
        }
        else if (s.mime.startsWith('text/')) {
            // Texto puro
            const t = s.textoParaCopiar || await s.blob.text();
            html  = `<pre style="font-family:monospace;white-space:pre-wrap;">${
                t.replace(/[<>]/g, c => ({'<':'&lt;','>':'&gt;'}[c]))
            }</pre>`;
            texto = t;
        }
        else if (s.isPDF) {
            // PDF: não conseguimos extrair texto nativamente.
            // Copiamos o nome do arquivo + URL original.
            texto = s.textoParaCopiar || `Documento PDF: ${s.filename}`;
            html  = `<p>${texto.replace(/\n/g, '<br>')}</p>`;
        }
        else {
            // Outros tipos
            texto = s.textoParaCopiar || `Documento: ${s.filename} (${s.mime})`;
            html  = `<p>${texto.replace(/\n/g, '<br>')}</p>`;
        }

        // Tenta Clipboard API (rich)
        if (navigator.clipboard && window.ClipboardItem) {
            const item = new ClipboardItem({
                'text/html':  new Blob([html],  { type: 'text/html' }),
                'text/plain': new Blob([texto], { type: 'text/plain' })
            });
            await navigator.clipboard.write([item]);
        } else {
            // Fallback: copia só o texto
            const ta = document.createElement('textarea');
            ta.value = texto;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
        }

        // Feedback de sucesso
        btn.classList.add('copiado');
        btn.innerHTML = '<i class="fas fa-check"></i> Copiado!';
        setTimeout(() => {
            btn.classList.remove('copiado');
            btn.innerHTML = original;
        }, 1800);

    } catch (err) {
        console.error('Erro ao copiar:', err);
        btn.classList.add('erro');
        btn.innerHTML = '<i class="fas fa-times"></i> Erro';
        setTimeout(() => {
            btn.classList.remove('erro');
            btn.innerHTML = original;
        }, 1800);
    }
});

/* ============================================================
   FECHAR — botão, clique fora, ESC
   ============================================================ */
document.getElementById('closeBtn').addEventListener('click', fecharPopup);

document.getElementById('pdfPopup').addEventListener('click', function (e) {
    if (e.target === this) fecharPopup();
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const popup = document.getElementById('pdfPopup');
        if (popup && popup.style.display === 'block') fecharPopup();
    }
});
</script>
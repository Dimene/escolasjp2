<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatório Financeiro - Mensalidades</title>
  <!-- Bootstrap 4 CSS (AdminLTE compatível) -->
  <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/bootstrap/css/bootstrap.min.css')); ?>">
  <!-- Font Awesome 5 (opcional, para ícones) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Estilos para impressão */
    @media print {
      .no-print { display: none !important; }
      .tab-pane { display: block !important; opacity: 1 !important; visibility: visible !important; }
      .nav-tabs { display: none; }
      body { background: white; }
      .card { border: none; box-shadow: none; }
      .table { width: 100%; border-collapse: collapse; }
      .table td, .table th { border: 1px solid #ddd; }
    }
    body {
      background: #f4f6f9;
    }
    .card-custom {
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      background: #fff;
    }
    .nav-tabs-custom {
      background: transparent;
      border: none;
    }
    .nav-tabs .nav-link {
      border-radius: 30px;
      margin-right: 8px;
      font-weight: 500;
      transition: 0.2s;
    }
    .nav-tabs .nav-link.active {
      background: linear-gradient(135deg, #007bff, #0056b3);
      color: white;
      border-color: transparent;
    }
    .tab-pane {
      padding: 20px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    canvas {
      max-height: 400px;
      width: 100%;
    }
    .table thead th {
      background: #007bff;
      color: white;
      font-weight: 600;
    }
    .table td, .table th {
      vertical-align: middle;
    }
    .btn-print {
      background: linear-gradient(135deg, #28a745, #1e7e34);
      border: none;
      border-radius: 40px;
      padding: 8px 24px;
      font-weight: 600;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: 0.2s;
    }
    .btn-print:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 12px rgba(0,0,0,0.15);
    }
    .total-row {
      background-color: #e9ecef;
      font-weight: bold;
    }
    hr {
      margin: 5px 0;
    }
  </style>
</head>
<body>

<div class="container mt-4">
  <!-- Card principal -->
  <div class="card-custom">
    <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 pt-4 px-4">
      <h3 class="mb-0"><i class="fas fa-chart-line text-primary mr-2"></i> Relatório de Mensalidades</h3>
      <button id="printButton" class="btn btn-print text-white no-print">
        <i class="fas fa-print mr-2"></i> Imprimir Relatório
      </button>
    </div>
    <div class="card-body p-4">
      <!-- Abas -->
      <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="graph-tab" data-toggle="tab" href="#graphPane" role="tab">
            <i class="fas fa-chart-bar mr-2"></i> Gráfico
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="table-tab" data-toggle="tab" href="#tablePane" role="tab">
            <i class="fas fa-table mr-2"></i> Relatório Texto
          </a>
        </li>
      </ul>

      <!-- Conteúdo das abas -->
      <div class="tab-content" id="myTabContent">
        <!-- Aba Gráfico -->
        <div class="tab-pane fade show active" id="graphPane" role="tabpanel">
          <canvas id="myChart" style="width:100%; max-height:450px;"></canvas>
        </div>

        <!-- Aba Tabela/Texto -->
        <div class="tab-pane fade" id="tablePane" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Mês</th>
                  <th>Alunos</th>
                  <th>Transferências</th>
                  <th>Desistentes</th>
                  <th><?php echo e($flag); ?> (pagos)</th>
                  <th>Alunos c/ Multa</th>
                  <th>Multas Pagas (MT)</th>
                  <th>Valor <?php echo e($flag); ?> (MT)</th>
                  <th>Total (MT)</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $totalMensalidades = 0;
                  $totalMultas = 0;
                  $geral = 0;
                ?>
                <?php $__currentLoopData = $arrayrelatorio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                    $valorMensal = $item['valorpagoMensalidades'] ?? 0;
                    $valorMulta = $item['valorpagodemulta'] ?? 0;
                    $totalLinha = $valorMensal + $valorMulta;
                    $totalMensalidades += $valorMensal;
                    $totalMultas += $valorMulta;
                    $geral += $totalLinha;
                  ?>
                  <tr>
                    <td>
                      <strong><?php echo e($item['mes']); ?></strong>
                      <a href="<?php echo e(route('mensalidade.Relatoriodetalhado', [$ano, $classe, $item['mesId']])); ?>" class="btn btn-sm btn-link p-0 ml-2" title="Ver detalhes">
                        <i class="fas fa-external-link-alt"></i>
                      </a>
                    </td>
                    <td><?php echo e($item['NrAlunos']); ?></td>
                    <td><?php echo e($item['tranferencias'] ?? 0); ?></td>
                    <td><?php echo e($item['disistentes'] ?? 0); ?></td>
                    <td><?php echo e($item['qtdQpagar'] ?? 0); ?></td>
                    <td><?php echo e($item['alunoscommulta'] ?? 0); ?></td>
                    <td class="text-success"><?php echo e(number_format($valorMulta, 2, ',', '.')); ?> MT</td>
                    <td class="text-primary"><?php echo e(number_format($valorMensal, 2, ',', '.')); ?> MT</td>
                    <td class="font-weight-bold"><?php echo e(number_format($totalLinha, 2, ',', '.')); ?> MT</td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
              <tfoot class="total-row">
                <tr>
                  <th colspan="6">Totais Gerais</th>
                  <th class="text-success"><?php echo e(number_format($totalMultas, 2, ',', '.')); ?> MT</th>
                  <th class="text-primary"><?php echo e(number_format($totalMensalidades, 2, ',', '.')); ?> MT</th>
                  <th class="font-weight-bold"><?php echo e(number_format($geral, 2, ',', '.')); ?> MT</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts necessários -->
<script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- Chart.js v3.9.1 (moderno) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
  // Dados passados do PHP para JavaScript (evita usar inputs escondidos)
  const dadosMeses = <?php echo json_encode($arrayrelatorio, 15, 512) ?>;

  // Extrair arrays para o gráfico
  const labels = dadosMeses.map(item => item.mes);
  const alunosInscritos = dadosMeses.map(item => item.NrAlunos);
  const alunosPagos = dadosMeses.map(item => item.qtdQpagar);
  const alunosNaoPagos = dadosMeses.map(item => item.NrAlunos - item.qtdQpagar);
  const valorMensalidades = dadosMeses.map(item => item.valorpagoMensalidades);
  const valorMultas = dadosMeses.map(item => item.valorpagodemulta);

  // Configuração do gráfico (linhas + barras - optamos por barras agrupadas para melhor visualização)
  const ctx = document.getElementById('myChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Alunos Inscritos',
          data: alunosInscritos,
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          borderRadius: 8
        },
        {
          label: 'Pagaram ' + '<?php echo e($flag); ?>',
          data: alunosPagos,
          backgroundColor: 'rgba(75, 192, 192, 0.6)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
          borderRadius: 8
        },
        {
          label: 'Não Pagaram ' + '<?php echo e($flag); ?>',
          data: alunosNaoPagos,
          backgroundColor: 'rgba(255, 99, 132, 0.6)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1,
          borderRadius: 8
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: { position: 'top' },
        tooltip: { mode: 'index', intersect: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: 'Número de Alunos' }
        },
        x: {
          title: { display: true, text: 'Meses' }
        }
      }
    }
  });

  // Botão de impressão: imprime o conteúdo das duas abas (gráfico e tabela)
  document.getElementById('printButton').addEventListener('click', function() {
    // Clona o conteúdo das duas abas (incluindo o gráfico e a tabela)
    const graphContent = document.getElementById('graphPane').cloneNode(true);
    const tableContent = document.getElementById('tablePane').cloneNode(true);

    // Cria uma nova janela para impressão
    const printWindow = window.open('', '_blank', 'width=1000,height=800');
    printWindow.document.write(`
      <!DOCTYPE html>
      <html>
      <head>
        <meta charset="UTF-8">
        <title>Relatório Mensalidades</title>
        <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/bootstrap/css/bootstrap.min.css')); ?>">
        <style>
          body { padding: 20px; font-family: 'Segoe UI', sans-serif; }
          .print-header { text-align: center; margin-bottom: 30px; }
          .print-header h2 { margin: 0; }
          .section-title { font-size: 1.5rem; margin: 20px 0 10px; border-bottom: 2px solid #007bff; display: inline-block; }
          canvas { max-width: 100%; height: auto; }
          table { width: 100%; border-collapse: collapse; margin-top: 20px; }
          th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
          th { background: #007bff; color: white; }
          .total-row { background: #f2f2f2; font-weight: bold; }
          @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none; }
          }
        </style>
      </head>
      <body>
        <div class="print-header">
          <h2>Relatório de Mensalidades</h2>
          <p>Período: ${new Date().toLocaleDateString()}</p>
        </div>
        <div>
          <div class="section-title">Gráfico Analítico</div>
          <div id="print-graph">${graphContent.innerHTML}</div>
          <div style="page-break-before: avoid; margin-top: 40px;">
            <div class="section-title">Detalhamento por Mês</div>
            <div id="print-table">${tableContent.innerHTML}</div>
          </div>
        </div>
        <script>
          // Redimensionar canvas para impressão (forçar tamanho)
          window.onload = function() {
            const canvas = document.querySelector('canvas');
            if (canvas) {
              canvas.style.width = '100%';
              canvas.style.height = 'auto';
            }
          };
        <\/script>
      </body>
      </html>
    `);
    printWindow.document.close();
    printWindow.print();
  });
</script>

</body>
</html>
<?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/registoAcademico/outrosPagamento/relatorio-ano-classe.blade.php ENDPATH**/ ?>
<?php
$request = Request();
$host = $request->getHost();
$subdomain = explode('.', $host)[0];

// Agrupar alunos por estado
$alunosPorEstado = [];

foreach ($retornoAlunos as $aluno) {

    $estado = ($aluno->TIPOSAIDAa == null)
        ? 'activo'
        : $aluno->TIPOSAIDAa;

    if (!isset($alunosPorEstado[$estado])) {
        $alunosPorEstado[$estado] = [];
    }

    $alunosPorEstado[$estado][] = $aluno;
}

// Ordenar estados
uksort($alunosPorEstado, function($a, $b) {

    if ($a === 'activo') return -1;
    if ($b === 'activo') return 1;

    return strcmp($a, $b);
});
?>

<div class="conteudo_tabela  card "  style="border-bottom: 3px solid #007bff;"

>

    <div class="row mb-3 p-3">

        <div class="col-md-8">
    <div class="input-group">
        <input
            type="text"
            id="searchFarmacos"
            class="form-control form-control-lg"
            placeholder="Pesquisar em todas as abas..."
            style="border-right: none; border-radius: 8px 0 0 8px;"
        >
        <div class="input-group-append">
            <span class="input-group-text bg-white" style="border-left: none; border-radius: 0 8px 8px 0; cursor: pointer;">
                <i class="fa fa-search text-primary"></i>
            </span>
        </div>
    </div>
</div>

<style>
    #searchFarmacos:focus {
        box-shadow: none;
        border-color: #ced4da;
        
        
    }
    
    .input-group-text:hover i {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }
</style>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Atualizar-matricula-Excel')): ?>
        <div class="col-md-4 text-right">

            <button
                type="button"
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#modalUploadAlunos"
            >
                <i class="fa fa-upload"></i>
                Importar Alunos
            </button>

        </div>
        <?php endif; ?>

    </div>



    
    
    

    <ul class="nav nav-tabs" id="estadoTabs" role="tablist">

        <?php $__currentLoopData = $alunosPorEstado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado => $alunos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php

                $isAtivo = ($estado === 'activo');

                $slug = Str::slug($estado);

                $tabId = "tab-{$slug}";
                $contentId = "content-{$slug}";
                $tableId = "table-{$slug}";

            ?>

            <li class="nav-item">

                <a
                    class="nav-link <?php echo e($isAtivo ? 'active' : ''); ?>"
                    id="<?php echo e($tabId); ?>"
                    data-toggle="tab"
                    href="#<?php echo e($contentId); ?>"
                    role="tab"
                    aria-controls="<?php echo e($contentId); ?>"
                    aria-selected="<?php echo e($isAtivo ? 'true' : 'false'); ?>"
                >

                    <i class="fa fa-<?php echo e($estado == 'activo' ? 'check-circle' : 'times-circle'); ?>"></i>

                    <?php echo e(ucfirst($estado)); ?>


                    <span class="badge badge-pill <?php echo e($isAtivo ? 'badge-primary' : 'badge-secondary'); ?> badge-count">
                        <?php echo e(count($alunos)); ?>

                    </span>

                </a>

            </li>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </ul>

    
    
    

    <div class="tab-content mt-3 " id="estadoTabsContent">

        <?php $__currentLoopData = $alunosPorEstado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado => $alunos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php

                $isAtivo = ($estado === 'activo');

                $slug = Str::slug($estado);

                $contentId = "content-{$slug}";
                $tableId = "table-{$slug}";

            ?>

            <div
                class="tab-pane fade <?php echo e($isAtivo ? 'show active' : ''); ?>"
                id="<?php echo e($contentId); ?>"
                role="tabpanel"
                aria-labelledby="tab-<?php echo e($slug); ?>"
            >

                <div class="table-responsive">

                    <table
                        id="<?php echo e($tableId); ?>"
                        class="table  table-striped tabelaEstado"
                        width="100%"
                    >

                        <thead>

                         <th>#</th>
<th>Nome</th>
<th>Sexo</th>
<th>Idade</th>
<th>Classe</th>
<th>turma</th>
<th>Endere&ccedil;o</th>
<th>Data.Insc</th>
<th>Estado</th>

<?php if(
    Gate::check('Modificar-Estado') ||
    Gate::check('Editar-Aluno') ||
    Gate::check('Ver-Aluno')
): ?>
    <th class="no-export">A&ccedil;&atilde;o</th>
<?php endif; ?>

                        </thead>

                        <tbody>

                            <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php
                                    $tipopagamento = $aluno->tipopagamentoNome ?? '';
                                ?>

                                <?php if(
                                    Gate::check("Visualizar-{$tipopagamento}") 
                                   
                                    ||Gate::check('Ver-Aluno')||Gate::check('Modificar-Estado')||Gate::check('Editar-Aluno')
                                ): ?>

                                <tr>

                                    <td><?php echo e($index + 1); ?></td>

                                    <td><?php echo e($aluno->nome ?? 'N/A'); ?></td>

                                    <td><?php echo e($aluno->sexo ?? 'N/A'); ?></td>

                                    <td>

                                        <?php
                                            $dataNasc = Carbon\Carbon::parse(
                                                $aluno->dataNascimento ?? '2000-01-01'
                                            );
                                        ?>

                                        <?php echo e(Carbon\Carbon::now()->year - $dataNasc->year); ?>


                                    </td>

                                    <td><?php echo e($aluno->classe ?? 'N/A'); ?></td>
                                    <td><?php echo e($aluno->turma ?? 'N/A'); ?></td>

                                    <td><?php echo e($aluno->Endereco ?? 'N/A'); ?></td>

                                    <td>
                                        <?php echo e(Carbon\Carbon::parse($aluno->datainscricao ?? now())->format('d/m/Y')); ?>

                                    </td>

                                    <td>

                                        <?php if($aluno->TIPOSAIDAa == null): ?>

                                            <span class="badge badge-success">
                                                Activo
                                            </span>

                                        <?php else: ?>

                                            <span class="badge badge-danger">
                                                <?php echo e($aluno->TIPOSAIDAa); ?>

                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <?php if(
                                        Gate::check('Modificar-Estado') ||
                                        Gate::check('Editar-Aluno') ||
                                        Gate::check('Ver-Aluno')
                                    ): ?>

                                    <td class="no-export">
                                        <div class="btn-group btn-group-sm">

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Modificar-Estado')): ?>

                                            <button
                                                class="btn btn-warning tranferir_Desistencia"
                                                nome="<?php echo e($aluno->nome); ?>"
                                                classeAluno="<?php echo e($aluno->classe); ?>"
                                                avatar="<?php echo e($aluno->avatar ?? ''); ?>"
                                                anolectivo="<?php echo e($aluno->anolectivo ?? ''); ?>"
                                                idaluno_classe_id="<?php echo e($aluno->idAlunoclasse ?? ''); ?>"
                                            >
                                                <i class="fa fa-paper-plane"></i>
                                            </button>

                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Editar-Aluno')): ?>

                                            <a
                                                class="btn btn-primary"
                                                href="<?php echo e(route('aluno.edititaer', [$aluno->id, $aluno->anolectivo_id ?? 1])); ?>"
                                            >
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Ver-Aluno')): ?>

                                            <button
                                                class="btn btn-info visualizar"
                                                idcodigo="<?php echo e($aluno->id); ?>"
                                                anolectivo="<?php echo e($aluno->anolectivo_id ?? 1); ?>"
                                            >
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <?php endif; ?>

                                        </div>

                                    </td>

                                    <?php endif; ?>

                                </tr>

                                <?php endif; ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>

                </div>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

</div>




<!-- Modal -->
<div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content  ">

            <div class="conteudobodi"></div>

            <div class="conteudobodiTRanfere">
                 <form action="<?php echo e(Route('aluno.saidaTran')); ?>" method="get">
                                <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="card-title">Registe o tipo de Saida do Aluno</h5>
                    </div>

                    <!--<div class="card-body">-->
                        <!--<fieldset>-->
                            <div class="row">
                                <div class="col-md-3">
                                    <img   class="avatar-aluno" src="<?php echo e(asset('storage/'.$subdomain.'/fotoAluno/')); ?>" alt=""
                                        style="width:100%; height:100%; border-radius:10px;">
                                </div>
                                
<div class="col">
                                    <div class="row">
                                        <div class="col-md-6"><label><b>Nome:</b></label></div>
                                        <div class="col-md-6"><span class="nomealuno"></span></div>

                                        <div class="col-md-6"><label><b>Classe:</b></label></div>
                                        <div class="col-md-6"><span class="classealunoSpan"></span></div>

                                        <div class="col-md-6"><label><b>Tipo de saida:</b></label></div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="TiposaidaSelect">
                                                <?php $__currentLoopData = $tipossaida; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipossaidaItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($tipossaidaItem->id); ?>">
                                                        <?php echo e($tipossaidaItem->Descricao); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6"><label><b> M&ecirc;s :</b></label></div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="mes_id">
                                                <?php $__currentLoopData = $mes->where('id','<',13); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mesItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($mesItem->id); ?>">
                                                        <?php echo e($mesItem->Descricao); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <!--</div>-->
                        <!--</fieldset>-->
                    </div>

                    <div class="card-footer text-right">

                            <?php echo csrf_field(); ?>
                            <input name="idAluno" type="hidden">
                            <input name="idMes" type="hidden">
                            <input name="Tiposaida" type="hidden">
                            <button type="submit" class="btn btn-outline-primary">Submeter</button>
                        </form>
                    <!--</div>-->
                <!--</div>-->
            </div>

        </div>
           </div>
    </div>
</div>
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
 <link rel="stylesheet" href="<?php echo e(asset('Datatable/css/buttons.dataTables.min.css')); ?>">


<script>

var tables = {};

$(document).ready(function() {

    inicializarTabelas();

    inicializarTabs();

    pesquisaGlobal();

});

function inicializarTabelas() {

    $('.tabelaEstado').each(function() {

        let tabela = $(this);

        let tableId = tabela.attr('id');

        let estado = tableId.replace('table-', '');

        tables[estado] = tabela.DataTable({

            responsive: true,

            dom: 'Bfrtip',

            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="fa fa-copy"></i> Copiar',
                    className: 'export-action export-copy',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: 'export-action export-excel',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Imprimir',
                    className: 'export-action export-print',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }
            ],

            pageLength: 5,

            language: {
                url: "/Datatable/pt/Portuguese-Brasil.json"
            }

        });

    });

}

function inicializarTabs() {

    $('#estadoTabs a').on('shown.bs.tab', function(e) {

        let target = $(e.target).attr('href');

        let estado = target.replace('#content-', '');

        if (tables[estado]) {

            setTimeout(function() {

                tables[estado]
                    .columns
                    .adjust()
                    .responsive
                    .recalc();

            }, 200);

        }

    });

}

function pesquisaGlobal() {

    $('#searchFarmacos').on('keyup', function() {

        let valor = $(this).val();

        $.each(tables, function(index, table) {

            table.search(valor).draw();

        });

    });

}




</script>

<style>

.nav-tabs .nav-link{

    font-weight:bold;

}

.nav-tabs .nav-link.active{

    background:#007bff;
    color:white !important;

}

.badge-count{

    margin-left:8px;

}


/* Esconder todos os inputs de search do DataTable */
.dataTables_filter {
    display: none !important;
}

.conteudo_tabela .dt-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 14px;
}

.conteudo_tabela .dt-buttons .dt-button.export-action {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin: 0;
    padding: 8px 14px;
    border: 0;
    border-radius: 8px;
    color: #fff !important;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.4;
    box-shadow: 0 2px 5px rgba(31, 41, 55, 0.16);
    transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
}

.conteudo_tabela .dt-buttons .dt-button.export-action:hover {
    color: #fff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(31, 41, 55, 0.2);
    filter: brightness(1.05);
}

.conteudo_tabela .dt-buttons .dt-button.export-action:focus-visible {
    outline: 3px solid rgba(0, 123, 255, 0.3);
    outline-offset: 2px;
}

.conteudo_tabela .dt-buttons .dt-button.export-copy {
    background: linear-gradient(135deg, #5271c4, #3c55a5);
}

.conteudo_tabela .dt-buttons .dt-button.export-excel {
    background: linear-gradient(135deg, #28a66a, #18834f);
}

.conteudo_tabela .dt-buttons .dt-button.export-print {
    background: linear-gradient(135deg, #3298b5, #21758e);
}


</style>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/Alunos-inscritos.blade.php ENDPATH**/ ?>
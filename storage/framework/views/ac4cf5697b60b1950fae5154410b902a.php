<?php $__env->startSection('title', 'Editar Tabela de Valores'); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* Animações e estilos modernos */
    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 15px;
        border: none;
    }

    .form-group-modern {
        margin-bottom: 20px;
    }

    .label-modern {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
        font-size: 0.9rem;
        letter-spacing: 0.3px;
    }

    .input-modern, .select-modern {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 15px;
        width: 100%;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .input-modern:focus, .select-modern:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .input-modern:disabled, .select-modern:disabled {
        background: #f3f4f6;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .list-group-modern {
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e5e7eb;
    }

    .list-group-item-modern {
        border: none;
        border-bottom: 1px solid #e5e7eb;
        padding: 10px 15px;
        transition: all 0.2s ease;
    }

    .list-group-item-modern:hover {
        background: #f8fafc;
        transform: translateX(5px);
    }

    .list-group-item-modern:last-child {
        border-bottom: none;
    }

    .checkbox-custom {
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        user-select: none;
        display: inline-block;
    }

    .checkbox-custom input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark-custom {
        position: absolute;
        top: 0;
        left: 0;
        height: 22px;
        width: 22px;
        background-color: #f9fafb;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .checkbox-custom:hover input ~ .checkmark-custom {
        background-color: #f3f4f6;
        border-color: #667eea;
    }

    .checkbox-custom input:checked ~ .checkmark-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }

    .checkmark-custom:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-custom input:checked ~ .checkmark-custom:after {
        display: block;
    }

    .checkbox-custom .checkmark-custom:after {
        left: 7px;
        top: 3px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .btn-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1);
        color: white;
    }

    .btn-modern:active {
        transform: translateY(0);
    }

    .btn-cancel {
        background: #6c757d;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    .badge-disabled {
        background: #f59e0b;
        color: white;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 10px;
    }

    .separator {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        margin: 20px 0;
    }

    .info-box {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
        border-radius: 12px;
        padding: 12px 15px;
        margin-bottom: 20px;
        border-left: 4px solid #0ea5e9;
    }

    /* Loading spinner */
    .loading-spinner {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.6s ease-in-out infinite;
        margin-right: 8px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Scrollbar */
    .scrollable-content::-webkit-scrollbar {
        width: 8px;
    }

    .scrollable-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .scrollable-content::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }
</style>

<div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-cogs"></i> Gestão de Administrativa</a>
            </li>

 <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-sliders"></i>  Configuracoes</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-table"></i> <b>Tabela de  Valores</b>
            </li>
        </ol>
    </div>
<div class="">


    <?php if($errors->any()): ?>
        <div class="container-fluid">
            <div class="alert alert-danger fade-in" style="border-radius: 12px; border: none;">
                <div class="d-flex align-items-center">
                    <i class="fa fa-exclamation-triangle fa-2x mr-3"></i>
                    <div>
                        <strong class="d-block mb-1">Erros de validação:</strong>
                        <ul class="mb-0 pl-3">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php
        $detalhes = json_decode($tabelaItem->detalhes ?? '[]');
        $temMeses = $MesescomDados->isNotEmpty();
        $temClasses = $classescomDados->isNotEmpty();
    ?>

    <div class="container-fluid fade-in">
        <div class="row">
            <div class="col-12">
                <?php echo $__env->make("Componetes.menu-componte-tabelavalores", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-modern">
                    <div class="card-header-modern">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-pen-alt fa-2x mr-3"></i>
                            <div>
                                <h4 class="mb-0" style="font-weight: 600;">Formulário de Edição</h4>
                                <small class="opacity-75">Preencha os campos abaixo para atualizar os dados</small>
                            </div>
                        </div>
                    </div>

                    <div class="p-4" style="background: white;">
                        <form id="formTabelaValores" action="<?php echo e(route('TabelaValores.update', $tabelaItem->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field("PUT"); ?>

                            <div class="row">
                                <!-- COLUNA 1: Informações Básicas -->
                                <div class="col-lg-4 mb-4">
                                    <div class="info-box">
                                        <i class="fa fa-info-circle mr-2" style="color: #0ea5e9;"></i>
                                        <small class="text-muted">Campos desabilitados não podem ser alterados pois já possuem dados associados</small>
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="label-modern" for="my-select-AnoLectivo">
                                            <i class="fa fa-calendar mr-2" style="color: #667eea;"></i>
                                            Ano Lectivo
                                            <?php if($temMeses): ?>
                                                <span class="badge-disabled">
                                                    <i class="fa fa-lock mr-1"></i> Bloqueado
                                                </span>
                                            <?php endif; ?>
                                        </label>
                                        <select class="select-modern" id="my-select-AnoLectivo" name="AnoLectivo"
                                            <?php echo e($temMeses ? 'disabled' : ''); ?>>
                                            <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anolectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($anolectivoItem->id); ?>"
                                                    <?php if($tabelaItem->anolectivo_id == $anolectivoItem->id): echo 'selected'; endif; ?>>
                                                    <?php echo e($anolectivoItem->anolectivo); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="label-modern" for="my-Descricao">
                                            <i class="fa fa-tag mr-2" style="color: #667eea;"></i>
                                            Tipo de Pagamento
                                            <?php if($temMeses): ?>
                                                <span class="badge-disabled">
                                                    <i class="fa fa-lock mr-1"></i> Bloqueado
                                                </span>
                                            <?php endif; ?>
                                        </label>
                                        <select class="select-modern" id="my-Descricao" name="Descricao"
                                            <?php echo e($temMeses ? 'disabled' : ''); ?>>
                                            <?php $__currentLoopData = $tipopagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>"
                                                    <?php if($tabelaItem->Descricao == $item->Descricao): echo 'selected'; endif; ?>>
                                                    <?php echo e($item->Descricao); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="label-modern" for="my-Montante">
                                            <i class="fa fa-money-bill-wave mr-2" style="color: #667eea;"></i>
                                            Montante (MZN)
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-0">MT</span>
                                            </div>
                                            <input type="text"
                                                   id="my-Montante"
                                                   name="Montante"
                                                   class="input-modern"
                                                   value="<?php echo e(number_format($tabelaItem->valorDescricao, 2, ',', '.')); ?>">
                                        </div>
                                        <small class="text-muted">Valor em Meticais (MZN)</small>
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="label-modern" for="my-Multa">
                                            <i class="fa fa-percent mr-2" style="color: #667eea;"></i>
                                            Percentagem de Multa
                                        </label>
                                        <div class="input-group">
                                            <input type="number"
                                                   id="my-Multa"
                                                   name="Multa"
                                                   class="input-modern"
                                                   value="<?php echo e($tabelaItem->multa); ?>"
                                                   step="0.01"
                                                   min="0">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-light border-0">%</span>
                                            </div>
                                        </div>
                                        <small class="text-muted">Percentual aplicado em caso de atraso</small>
                                    </div>
                                </div>

                                <!-- COLUNA 2: CLASSES -->
                                <div class="col-lg-4 mb-4">
                                    <div class="info-box">
                                        <i class="fa fa-users mr-2" style="color: #0ea5e9;"></i>
                                        <small class="text-muted">Selecione as classes que terão acesso a este valor</small>
                                    </div>

                                    <div class="list-group-modern classesDiv" style="max-height: 380px; overflow-y: auto;">
                                        <?php $__currentLoopData = $clases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="list-group-item-modern checkbox-custom d-flex align-items-center justify-content-between">
                                                <div>
                                                    <input type="checkbox"
                                                           class="classes"
                                                           name="classes[]"
                                                           value="<?php echo e($classe->id); ?>"
                                                           <?php if($classeporValor->pluck('classe_id')->contains($classe->id)): echo 'checked'; endif; ?>
                                                           <?php if($classescomDados->pluck('classe_id')->contains($classe->id)): echo 'disabled'; endif; ?>>
                                                    <span class="checkmark-custom"></span>
                                                    <strong><?php echo e($classe->Descricao); ?></strong>
                                                </div>
                                                <?php if($classescomDados->pluck('classe_id')->contains($classe->id)): ?>
                                                    <span class="badge badge-warning">
                                                        <i class="fa fa-check-circle"></i> Já possui dados
                                                    </span>
                                                <?php endif; ?>
                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <!-- COLUNA 3: MODALIDADES DE PAGAMENTO -->
                                <div class="col-lg-4 mb-4">
                                    <div class="info-box">
                                        <i class="fa fa-credit-card mr-2" style="color: #0ea5e9;"></i>
                                        <small class="text-muted">Configure as modalidades de pagamento e prazos</small>
                                    </div>
                                    <div style="max-height: 380px; overflow-y: auto;" class="scrollable-content">
                                        <?php echo $__env->make("Componetes.modalidade-pagamento", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="separator"></div>

                            <!-- Botões de Ação -->
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="button" class="btn-cancel mr-2" onclick="window.location.href='/RegistoAcademico/TabelaValores/show'">
                                        <i class="fa fa-times mr-2"></i> Cancelar
                                    </button>
                                    <button type="button" class="btn-modern guardarpreco">
                                        <i class="fa fa-save mr-2"></i> Atualizar Dados
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function(){
    // Formatação do campo Montante
    function formatMoneyInput(value) {
        let number = value.replace(/[^\d]/g, '');
        if (number) {
            number = (parseInt(number) / 100).toFixed(2);
            return number.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
        return '';
    }

    $("#my-Montante").on('keyup', function() {
        let value = $(this).val();
        $(this).val(formatMoneyInput(value));
    });

    // Botão de salvar
    $(".guardarpreco").on("click", function(e){
        e.preventDefault();

        let btn = $(this);
        let originalText = btn.html();

        // Mostrar loading
        btn.html('<span class="loading-spinner"></span> Atualizando...').prop('disabled', true);

        // Validação básica
        let montante = $("#my-Montante").val();
        if (!montante || montante === "") {
            Swal.fire("Erro", "O campo Montante é obrigatório.", "error");
            btn.html(originalText).prop('disabled', false);
            return;
        }

        if ($(".classes:checked").length === 0) {
            Swal.fire("Erro", "Selecione pelo menos uma classe.", "error");
            btn.html(originalText).prop('disabled', false);
            return;
        }

        if ($(".meses:checked").length === 0) {
            Swal.fire("Erro", "Selecione pelo menos uma modalidade de pagamento.", "error");
            btn.html(originalText).prop('disabled', false);
            return;
        }

        // Coletar dados
        let data = {
            _token: "<?php echo e(csrf_token()); ?>",
            _method: "PUT",
            AnoLectivo: $("#my-select-AnoLectivo").val(),
            Descricao: $("#my-Descricao").val(),
            Montante: $("#my-Montante").val().replace(/[^\d,-]/g, '').replace(',', '.'),
            Multa: $("#my-Multa").val(),
            classes: $(".classes:checked").map(function(){ return $(this).val(); }).get(),
            items: $(".meses:checked").map(function(){ return $(this).val(); }).get(),
            periodepagamento: $(".periodepagamento").val()
        };

        // Dados específicos
        if ($("[name='DataFimGeericas']").is(":visible") && $("[name='DataFimGeericas']").val()) {
            data.DataFimGeericas = $("[name='DataFimGeericas']").val();
        }

        if ($(".DataInicio:visible").length > 0) {
            data.DataInicio = $(".DataInicio:visible").map(function(){ return $(this).val(); }).get();
            data.DataFim = $(".DataFim:visible").map(function(){ return $(this).val(); }).get();
        }

        // Enviar AJAX
        $.ajax({
            url: "<?php echo e(route('TabelaValores.update', $tabelaItem->id)); ?>",
            type: "POST",
            data: data,
            success: function(response){
                Swal.fire({
                    title: "Sucesso!",
                    text: "Dados atualizados com sucesso.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '/RegistoAcademico/TabelaValores/show';
                });
            },
            error: function(xhr){
                console.error(xhr.responseText);
                let errorMsg = "Falha ao atualizar os dados.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire("Erro", errorMsg, "error");
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Contador de seleções
    function updateCounters() {
        let classesCount = $(".classes:checked").length;
        let mesesCount = $(".meses:checked").length;

        if (!$(".classesCount").length) {
            $(".classesDiv").before(`<small class="text-muted mb-2 d-block classesCount">
                <i class="fa fa-check-circle mr-1"></i> ${classesCount} classe(s) selecionada(s)
            </small>`);
        } else {
            $(".classesCount").html(`<i class="fa fa-check-circle mr-1"></i> ${classesCount} classe(s) selecionada(s)`);
        }
    }

    $(document).on("change", ".classes, .meses", updateCounters);
    updateCounters();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/tabelavalores-edit.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Ano Lectivo'); ?>
<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="jquery.dataTables.min.css"/>
<link rel="stylesheet" href="buttons.dataTables.min.css"/>

<style>
    /* Animações e transições suaves */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12) !important;
    }

    /* Estilização dos checkboxes e radio buttons */
    .custom-checkbox-modern {
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
    }

    .custom-checkbox-modern input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 22px;
        width: 22px;
        background-color: #f8f9fa;
        border: 2px solid #dee2e6;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .custom-checkbox-modern:hover input ~ .checkmark {
        background-color: #e9ecef;
        border-color: #80bdff;
    }

    .custom-checkbox-modern input:checked ~ .checkmark {
        background-color: #007bff;
        border-color: #007bff;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .custom-checkbox-modern input:checked ~ .checkmark:after {
        display: block;
    }

    .custom-checkbox-modern .checkmark:after {
        left: 7px;
        top: 3px;
        width: 6px;
        height: 11px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    /* Scrollbar customizada */
    .scrollable-div::-webkit-scrollbar {
        width: 8px;
    }

    .scrollable-div::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .scrollable-div::-webkit-scrollbar-thumb {
        background: #007bff;
        border-radius: 10px;
    }

    .scrollable-div::-webkit-scrollbar-thumb:hover {
        background: #0056b3;
    }

    /* Campos de entrada com efeito focus */
    .form-control-modern, .custom-select-modern {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 10px 15px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-control-modern:focus, .custom-select-modern:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
        background: white;
    }

    /* Labels modernas */
    .label-modern {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        display: block;
        font-size: 0.9rem;
        letter-spacing: 0.3px;
    }

    /* Botão com efeito */
    .btn-modern {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    }

    .btn-modern:active {
        transform: translateY(0);
    }

    /* List group moderno */
    .list-group-modern {
        border-radius: 12px;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .list-group-modern .list-group-item {
        border: none;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s ease;
        padding: 12px 20px;
    }

    .list-group-modern .list-group-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }

    .list-group-modern .list-group-item:last-child {
        border-bottom: none;
    }

    /* Card principal */
    .main-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .main-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0px 0px;
    }

    /* Alert aprimorado */
    .alert-modern {
        border: none;
        border-radius: 12px;
        padding: 15px 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    /* Badge para contagem de seleções */
    .selection-badge {
        background: #007bff;
        color: white;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: 10px;
    }

    /* Divisor estilizado */
    .section-divider {
        height: 3px;
        background: linear-gradient(90deg, #007bff, #6610f2, #6f42c1);
        width: 60px;
        margin: 10px auto 20px auto;
        border-radius: 3px;
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
            <div class="alert alert-danger alert-modern fade-in" role="alert">
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

    <div class="container-fluid fade-in">
        <div class="row">
            <div class="col-12">
                <?php echo $__env->make("Componetes.menu-componte-tabelavalores", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="col-12">
                <div class="main-card card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-edit fa-2x mr-3"></i>
                            <div>
                                <h3 class="mb-0" style="font-weight: 600;">Registo de Valores</h3>

                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <?php if(isset($colecao)): ?>
                            <div class="alert alert-success alert-modern fade-in" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check-circle fa-2x mr-3"></i>
                                    <div>
                                        <strong>Sucesso!</strong>
                                        <p class="mb-0"><?php echo e($colecao); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form class="formularioValores" action="<?php echo e(route('TabelaValores.store')); ?>" method="post">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <!-- Coluna Principal -->
                                <div class="col-lg">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="text-center mb-4">
                                                <i class="fa fa-coins fa-3x text-primary"></i>
                                                <h5 class="mt-2 mb-0">Informações Financeiras</h5>
                                                <div class="section-divider"></div>
                                            </div>

                                            <div class="form-group">
                                                <label class="label-modern" for="my-select-AnoLectivo">
                                                    <i class="fa fa-calendar mr-2 text-primary"></i>
                                                    Ano Lectivo <span class="text-danger">*</span>
                                                </label>
                                                <select id="my-select-AnoLectivo" class="form-control custom-select-modern" name="AnoLectivo">
                                                    <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anolectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($anolectivoItem->id); ?>" <?php echo e($loop->first ? 'selected' : ''); ?>>
                                                            <?php echo e($anolectivoItem->anolectivo); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small class="text-muted">Selecione o ano lectivo para configuração</small>
                                            </div>

                                            <div class="form-group">
                                                <label class="label-modern" for="my-Descricao">
                                                    <i class="fa fa-tag mr-2 text-primary"></i>
                                                    Tipo de Pagamento <span class="text-danger">*</span>
                                                </label>
                                                <select id="my-Descricao" class="form-control custom-select-modern" name="Descricao">
                                                    <?php $__currentLoopData = $tipopagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipopagamentoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($tipopagamentoItem->id); ?>"><?php echo e($tipopagamentoItem->Descricao); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="label-modern" for="my-Montante">
                                                    <i class="fa fa-money-bill-wave mr-2 text-primary"></i>
                                                    Montante <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-light border-0">MZN</span>
                                                    </div>
                                                    <input id="my-Montante" class="form-control form-control-modern" type="text"
                                                           name="Montante" placeholder="0,00" required>
                                                </div>
                                                <small class="text-muted">Insira o valor em Metical</small>
                                            </div>

                                            <div class="form-group">
                                                <label class="label-modern" for="my-Multa">
                                                    <i class="fa fa-percent mr-2 text-primary"></i>
                                                    Percentagem de Multa
                                                </label>
                                                <div class="input-group">
                                                    <input id="my-Multa" class="form-control form-control-modern" type="text"
                                                           name="Multa" value="0" placeholder="0">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-light border-0">%</span>
                                                    </div>
                                                </div>
                                                <small class="text-muted">Valor percentual para multas (0 para sem multa)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Classes -->
                                <div class="col-lg ">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="text-center mb-4">
                                                <i class="fa fa-chalkboard-teacher fa-3x text-primary"></i>
                                                <h5 class="mt-2 mb-0">Classes</h5>
                                                <div class="section-divider"></div>
                                                <div class="mb-2">
                                                    <span class="selection-badge" id="classesCounter">0 selecionadas</span>
                                                </div>
                                            </div>

                                            <div class="scrollable-div" style="height: 400px;">
                                                <div class="list-group list-group-modern classesDiv">
                                                    <?php $__currentLoopData = $clases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <label class="list-group-item custom-checkbox-modern">
                                                            <input type="checkbox" value="<?php echo e($classe->id); ?>" class="classes" name="classes[]">
                                                            <span class="checkmark"></span>
                                                            <strong><?php echo e($classe->Descricao); ?></strong>
                                                            <small class="d-block text-muted mt-1">Classe de ensino</small>
                                                        </label>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modalidades -->
                                <div class="col-lg">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="text-center mb-4">
                                                <i class="fa fa-credit-card fa-3x text-primary"></i>
                                                <h5 class="mt-2 mb-0">Modalidades de Pagamento</h5>
                                                <div class="section-divider"></div>
                                                <div class="mb-2">
                                                    <span class="selection-badge" id="modalidadesCounter">0 selecionadas</span>
                                                </div>
                                            </div>

                                            <div id="configModalidadeContainerASAS" style="max-height: 400px; overflow-y: auto;">
                                                <?php echo $__env->make("Componetes.modalidade-pagamento", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="row mt-3">
                                <div class="col-12 text-right">
                                    <button type="button" class="btn btn-light btn-lg mr-2" onclick="window.history.back()">
                                        <i class="fa fa-times mr-2"></i> Cancelar
                                    </button>
                                    <button class="btn btn-modern btn-lg guardarpreco" type="button">
                                        <i class="fa fa-save mr-2"></i> Salvar Configuração
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

<?php $__env->startPush('script'); ?>
<script>
$(document).ready(function(){
    // Contador de seleção de classes
    function updateClassesCounter() {
        let count = $(".classes:checked").length;
        $("#classesCounter").text(count + " selecionada" + (count !== 1 ? "s" : ""));
    }

    // Contador de modalidades
    function updateModalidadesCounter() {
        let count = $(".meses:checked").length;
        $("#modalidadesCounter").text(count + " selecionada" + (count !== 1 ? "s" : ""));
    }

    // Event listeners para contadores
    $(document).on("change", ".classes", updateClassesCounter);
    $(document).on("change", ".meses", updateModalidadesCounter);

    // Inicializar contadores
    updateClassesCounter();
    updateModalidadesCounter();

    // Efeito de loading ao salvar
    $(".guardarpreco").click(function(){
        let btn = $(this);
        let originalHtml = btn.html();

        // Remover mensagens de erro anteriores
        $(".is-invalid").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        let valido = true;

        // Validação dos campos
        if ($("#my-select-AnoLectivo").val().trim() === "") {
            erroCampo("#my-select-AnoLectivo", "O Ano Lectivo é obrigatório.");
            valido = false;
        }

        if ($("#my-Descricao").val().trim() === "") {
            erroCampo("#my-Descricao", "A Descrição é obrigatória.");
            valido = false;
        }

        let montante = $("#my-Montante").val().trim().replace(/[^\d,-]/g, '');
        if (montante === "" || isNaN(parseFloat(montante)) || parseFloat(montante) <= 0) {
            erroCampo("#my-Montante", "O Montante deve ser um número válido e maior que 0.");
            valido = false;
        }

        let multa = $("#my-Multa").val().trim();
        if (multa === "" || isNaN(multa) || parseFloat(multa) < 0) {
            erroCampo("#my-Multa", "A Multa deve ser um número válido e maior ou igual a 0.");
            valido = false;
        }

        if ($(".classes:checked").length === 0) {
            erroCampoClasses(".classesDiv", "⚠️ Selecione pelo menos uma classe para continuar.");
            valido = false;
        }

        if ($(".meses:checked").length === 0) {
            erroCampoClasses(".mesesDiv", "⚠️ Selecione pelo menos uma modalidade de pagamento.");
            valido = false;
        }

        if (!valido) {
            // Scroll para o primeiro erro
            $('html, body').animate({
                scrollTop: $(".is-invalid:first").offset().top - 100
            }, 500);
            return;
        }

        // Mostrar loading
        btn.html('<i class="fa fa-spinner fa-spin mr-2"></i> Salvando...').prop('disabled', true);

        // Enviar os dados via AJAX
        $.ajax({
            url: "<?php echo e(route('TabelaValores.store')); ?>",
            type: "POST",
            data: $(".formularioValores").serialize(),
            success: function(response) {
                // Mostrar toast de sucesso
                if(response.success) {
                    toastr.success('Configuração salva com sucesso!', 'Sucesso');
                    setTimeout(function() {
                        window.location.href = '/RegistoAcademico/TabelaValores/show';
                    }, 1500);
                } else {
                    window.location.href = '/RegistoAcademico/TabelaValores/show';
                }
            },
            error: function(xhr) {
                btn.html(originalHtml).prop('disabled', false);
                let errorMsg = "Erro ao salvar os dados. Verifique e tente novamente.";
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                toastr.error(errorMsg, 'Erro');
            }
        });
    });

    function erroCampo(seletor, mensagem) {
        $(seletor).addClass("is-invalid");
        $(seletor).after(`<div class="invalid-feedback">⚠️ ${mensagem}</div>`);
    }

    function erroCampoClasses(seletor, mensagem) {
        $(seletor).prepend(`<div class="alert alert-warning alert-sm mb-2 p-2" style="font-size: 0.875rem;">${mensagem}</div>`);
        setTimeout(() => {
            $(seletor).find('.alert').fadeOut(300, function() { $(this).remove(); });
        }, 5000);
    }

    // Formatação do campo Montante
    $("#my-Montante").on('keyup', function() {
        let value = $(this).val().replace(/[^\d]/g, '');
        if(value) {
            value = parseInt(value).toLocaleString('pt-BR');
            $(this).val(value);
        }
    });
});
</script>

<style>
    .scrollable-div {
        height: auto;
        max-height: 400px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 5px;
    }

    .is-invalid {
        border-color: #dc3545 !important;
        background-image: none !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
    }

    .alert-sm {
        font-size: 0.875rem;
        padding: 8px 12px;
        border-radius: 8px;
    }

    /* Animações */
    .toast-success {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/tabelavalores-create.blade.php ENDPATH**/ ?>
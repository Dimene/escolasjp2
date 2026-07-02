<?php $__env->startSection('title', 'Actualizar Ano Lectivo'); ?>
<?php $__env->startSection('content'); ?>

    <style>
        /* ======================================== */
        /* ESTILOS MODERNOS */
        /* ======================================== */

        .fade-in {
            animation: fadeIn 0.4s ease-out;
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

        /* Cards Modernos */
        .card-modern {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            margin-bottom: 25px;
        }

        .card-modern:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .card-header-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border: none;
        }

        .card-header-modern h4 {
            margin: 0;
            font-weight: 600;
        }

        /* Lista de Anos */
        .list-group-modern {
            border-radius: 12px;
            overflow: hidden;
        }

        .list-group-item-modern {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .list-group-item-modern:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .ano-info {
            font-weight: 500;
            color: #374151;
        }

        .ano-modelo {
            font-size: 0.8rem;
            color: #667eea;
            margin-left: 10px;
        }

        .action-badges {
            display: flex;
            gap: 8px;
        }

        .badge-action {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .badge-edit {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
        }

        .badge-delete {
            background: linear-gradient(135deg, #f56565 0%, #c53030 100%);
            color: white;
        }

        .badge-action:hover {
            transform: translateY(-2px);
            color: white;
        }

        /* Formulário */
        .form-section {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
        }

        .form-title i {
            color: #667eea;
        }

        .form-group-modern {
            margin-bottom: 20px;
        }

        .label-modern {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .label-modern i {
            margin-right: 8px;
            color: #667eea;
        }

        .input-modern,
        .select-modern {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            width: 100%;
            transition: all 0.3s ease;
            background: #f9fafb;
            font-size: 0.95rem;
        }

        .input-modern:focus,
        .select-modern:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Seção de Divisão */
        .division-section {
            background: #f8fafc;
            border-radius: 16px;
            padding: 20px;
            margin-top: 20px;
        }

        .division-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: #374151;
            font-size: 1.1rem;
        }

        .division-row {
            display: grid;
            grid-template-columns: 1fr 2fr 2fr 0.5fr;
            gap: 15px;
            margin-bottom: 15px;
            align-items: center;
        }

        .btn-add {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border: none;
            border-radius: 10px;
            padding: 10px;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        }

        .btn-remove {
            background: linear-gradient(135deg, #f56565 0%, #c53030 100%);
            border: none;
            border-radius: 10px;
            padding: 10px;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-remove:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 101, 101, 0.3);
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            font-size: 0.9rem;
            margin-top: 20px;
            cursor: pointer;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(102, 126, 234, 0.3);
        }

        /* Alertas */
        .alert-modern {
            border: none;
            border-radius: 16px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .alert-success-modern {
            background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
            color: #1e7e34;
        }

        /* Breadcrumb */
        .breadcrumb-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .breadcrumb-modern .breadcrumb {
            background: transparent;
            margin: 0;
            padding: 0;
        }

        .breadcrumb-modern .breadcrumb-item {
            color: rgba(255, 255, 255, 0.9);
        }

        .breadcrumb-modern .breadcrumb-item a {
            color: white;
            text-decoration: none;
        }

        .breadcrumb-modern .breadcrumb-item.active {
            color: #ffd700;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .division-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .form-section {
                padding: 20px;
            }

            .list-group-item-modern {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .btn-submit {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid fade-in">
        <!-- Breadcrumb -->
        <div class="breadcrumb-modern">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#"><i class="fa fa-calendar"></i> Configurar Ano</a>
                </li>
                <li class="breadcrumb-item active">
                    <i class="fa fa-edit"></i> Actualizar Ano Lectivo
                </li>
            </ol>
        </div>

        <?php if(Session::get('mensage')): ?>
            <div class="alert alert-success-modern alert-modern">
                <i class="fa fa-check-circle mr-2"></i>
                <strong>Sucesso!</strong> <?php echo e(Session::get('mensage')); ?>

            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Coluna da Lista de Anos -->
            <div class="col-lg-4 mb-4">
                <div class="card-modern">
                    <div class="card-header-modern">
                        <h4><i class="fa fa-list"></i> Anos Lectivos</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group-modern">
                            <?php $__currentLoopData = $anoLectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anoLectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item-modern">
                                    <div>
                                        <span class="ano-info"><?php echo e($anoLectivoItem->anolectivo); ?></span>
                                        <span class="ano-modelo">(<?php echo e($anoLectivoItem->anomodelo->Descricao); ?>)</span>
                                    </div>
                                    <div class="action-badges">
                                        <a href="<?php echo e(Route('ano.edit', $anoLectivoItem->id)); ?>"
                                            class="badge-action badge-edit">
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <a href="<?php echo e(Route('ano.show', $anoLectivoItem->id)); ?>"
                                            class="badge-action badge-delete">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna do Formulário -->
            <div class="col-lg-8">
                <div class="form-section">
                    <div class="form-title">
                        <i class="fa fa-edit"></i> Actualizar Ano Lectivo
                    </div>

                    <form action="<?php echo e(Route('ano.update', $anoLectivoEscolhido->id)); ?>" method="POST">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-calendar"></i> Ano Lectivo
                                    </label>
                                    <select class="select-modern" name="anolectivo" required>
                                        <?php for($i = 0; $i < 10; $i++): ?>
                                            <option value="<?php echo e(2020 + $i); ?>"
                                                <?php if(2020 + $i == $anoLectivoEscolhido->anolectivo): ?> selected <?php endif; ?>>
                                                <?php echo e(2020 + $i); ?>

                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-play-circle"></i> Data de Início
                                    </label>
                                    <input type="date" class="input-modern" name="Inicio_ano"
                                        value="<?php echo e($anoLectivoEscolhido->Inicio ?? ''); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-stop-circle"></i> Data de Término
                                    </label>
                                    <input type="date" class="input-modern" name="Fim_ano"
                                        value="<?php echo e($anoLectivoEscolhido->Fim ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Seção de Divisão do Ano -->
                        <div class="division-section">
                            <div class="division-title">
                                <i class="fa fa-chart-line"></i> Divisão do Ano Lectivo
                            </div>

                            <div class="form-group-modern">
                                <label class="label-modern">
                                    <i class="fa fa-layer-group"></i> Modalidade
                                </label>
                                <select class="select-modern modalidadeV" name="modalidade" required>
                                    <option value="3" <?php if($anoLectivoEscolhido->modalidade == '3'): ?> selected <?php endif; ?>>Trimestre (3
                                        períodos)</option>
                                    <option value="2" <?php if($anoLectivoEscolhido->modalidade == '2'): ?> selected <?php endif; ?>>Semestre (2
                                        períodos)</option>
                                    <option value="4" <?php if($anoLectivoEscolhido->modalidade == '4'): ?> selected <?php endif; ?>>Bimestre (4
                                        períodos)</option>
                                    <option value="12" <?php if($anoLectivoEscolhido->modalidade == '12'): ?> selected <?php endif; ?>>Modular (12
                                        módulos)</option>
                                </select>
                            </div>

                            <div id="divisionContainer">
                                <?php $divisoes = $anoLectivoEscolhido->modalidadeDivisao;
                                 ?>
                                <?php if($divisoes->isEmpty()): ?>
                                    <div class="division-row ">
                                        <div>
                                            <input type="hidden" name="idDivisao[]" value="">
                                            <input type="number" class="input-modern" name="numero[]" placeholder="Nº"
                                                value="" required>
                                        </div>
                                        <div>
                                            <input type="date" class="input-modern" name="Inicio[]" value=""
                                                required>
                                        </div>
                                        <div>
                                            <input type="date" class="input-modern" name="Fim[]" value=""
                                                required>
                                        </div>
                                        <div>

                                            <button type="button" class="btn-add addicionar-mais-Divisao">
                                                <i class="fa fa-plus"></i> Adicionar
                                            </button>

                                        </div
                                        </div> <?php endif; ?>
                                        <?php $__currentLoopData = $divisoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $divisao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="division-row <?php echo e($index > 0 ? 'DIVISAOaCRECIDA' : ''); ?>">
                                                <div>
                                                    <input type="hidden" name="idDivisao[]"
                                                        value="<?php echo e($divisao->id ?? ''); ?>">
                                                    <input type="number" class="input-modern" name="numero[]"
                                                        placeholder="Nº" value="<?php echo e($divisao->divisao); ?>" required>
                                                </div>
                                                <div>
                                                    <input type="date" class="input-modern" name="Inicio[]"
                                                        value="<?php echo e($divisao->Inicio); ?>" required>
                                                </div>
                                                <div>
                                                    <input type="date" class="input-modern" name="Fim[]"
                                                        value="<?php echo e($divisao->Fim); ?>" required>
                                                </div>
                                                <div>
                                                    <?php if($index == 0): ?>
                                                        <button type="button" class="btn-add addicionar-mais-Divisao">
                                                            <i class="fa fa-plus"></i> Adicionar
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" class="btn-remove RemovedEVISAO">
                                                            <i class="fa fa-trash"></i> Remover
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <input type="hidden" class="controlerleght" value="<?php echo e(count($divisoes)); ?>">
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn-submit">
                                    <i class="fa fa-save"></i> Actualizar Configuração
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('Datatable/js/jquery-3.5.1.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            var $contador = 1;
            var $controler = 0;
            var $tamanho = parseInt($(".controlerleght").val()) || 1;

            $contador = $tamanho;

            // Adicionar nova divisão
            $(".addicionar-mais-Divisao").click(function(e) {
                $controler = parseInt($(".modalidadeV").val()) - $tamanho;

                if ($contador < $controler + $tamanho) {
                    var newRow = `
                <div class="division-row DIVISAOaCRECIDA">
                    <div>
                        <input type="hidden" name="idDivisao[]" value="">
                        <input type="number" class="input-modern" name="numero[]" placeholder="Nº" required>
                    </div>
                    <div>
                        <input type="date" class="input-modern" name="Inicio[]" placeholder="Data Início" required>
                    </div>
                    <div>
                        <input type="date" class="input-modern" name="Fim[]" placeholder="Data Fim" required>
                    </div>
                    <div>
                        <button type="button" class="btn-remove RemovedEVISAO">
                            <i class="fa fa-trash"></i> Remover
                        </button>
                    </div>
                </div>
            `;
                    $('#divisionContainer').append(newRow);
                    $contador++;
                }

                if ($contador >= $controler + $tamanho) {
                    $(".addicionar-mais-Divisao").prop('disabled', true).html(
                        '<i class="fa fa-check"></i> Limite Atingido');
                }
            });

            // Remover divisão
            $(document).on('click', '.RemovedEVISAO', function() {
                if ($contador > 1) {
                    $(this).closest('.division-row').remove();
                    $contador--;
                    $(".addicionar-mais-Divisao").prop('disabled', false).html(
                        '<i class="fa fa-plus"></i> Adicionar');
                }
            });

            // Resetar quando mudar modalidade
            $(".modalidadeV").change(function() {
                var novaModalidade = parseInt($(this).val());
                var currentRows = $('#divisionContainer .division-row').length;

                if (currentRows > novaModalidade) {
                    for (var i = currentRows; i > novaModalidade; i--) {
                        $('#divisionContainer .division-row:last-child').remove();
                    }
                    $contador = novaModalidade;
                }

                $(".addicionar-mais-Divisao").prop('disabled', false).html(
                    '<i class="fa fa-plus"></i> Adicionar');
                $tamanho = $contador;
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/Confugurar-ano-edit.blade.php ENDPATH**/ ?>
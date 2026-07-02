
<style>
    .container {
  max-width: 800px;
  margin: 0 auto;
}

.no-style {
  list-style: none;
  padding-left: 0;
  margin: 0;
}

.card-ele {
  transition: all 0.3s ease-in-out;
  border: 1px solid #ddd;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.logo {
  width: 18mm;
  height: 18mm;
  border-radius: 12px;
  overflow: hidden;
  background: #f3f3f3;
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 999;
  opacity: 0.5;
  pointer-events: none;
}

.cabecalho {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.flex-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}

    </style>
<?php
    $index = 0;
    $idsSelecionados = isset($detalhes) ? collect($detalhes)->pluck('mes')->toArray() : [];
    $idsComDados = isset($MesescomDados) ? collect($MesescomDados)->pluck('mes_id')->toArray() : [];
?>

<div class="container mt-4">
    <label for="tipoSelect">Selecione a forma de pagamento</label>

    <select class="form-control mb-4 periodepagamento" id="tipoSelect" name="periodepagamento"
        <?php if(isset($MesescomDados) && !empty($MesescomDados[0])): ?> disabled <?php endif; ?>>
        <optgroup>
            <?php $__currentLoopData = $mesepagamento->unique('anomdelo_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dede->anomdelo_id); ?>"
                    <?php if(isset($tabelaItem) && $tabelaItem->periodepagamento == $dede->anomdelo_id): ?> selected <?php endif; ?>>
                    <?php echo e($dede->DescricaoTipo); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </optgroup>
    </select>

    <?php $__currentLoopData = $mesepagamento->unique('anomdelo_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card card-ele mb-4" data-tipo="<?php echo e($dede->anomdelo_id); ?>">
            <div class="card-header">
                <?php echo e($dede->DescricaoTipo); ?>

            </div>
            <div class="card-body mesesDiv">
                <?php if($dede->anomdelo_id == 1): ?>
                    <label for="DataFimGeericas">Data Fim Genéricas</label>
                    <input type="number" min="1" max="28" name="DataFimGeericas" id="DataFimGeericas"
                        class="form-control"
                        value="<?php echo e(isset($tabelaItem) && $tabelaItem->periodepagamento == 1 ? carbon\Carbon::create($detalhes[0]->limite)->format('d') : 10); ?>">
                <?php endif; ?>

                <ul class="no-style">
                    <?php $__currentLoopData = $mesepagamento->where('DescricaoTipo', $dede->DescricaoTipo); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemselec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="form-check">
                                <input type="checkbox"
                                    class="form-check-input meses"
                                    id="item<?php echo e($itemselec->id); ?>"
                                    value="<?php echo e($itemselec->id); ?>"
                                    name="items[]"
                                    <?php if(in_array($itemselec->id, $idsSelecionados)): ?> checked <?php endif; ?>
                                    <?php if(in_array($itemselec->id, $idsComDados)): ?> disabled <?php endif; ?>>
                                <label class="form-check-label" for="item<?php echo e($itemselec->id); ?>">
                                    <?php echo e($itemselec->Descricao); ?>

                                </label>
                            </div>

                            <?php if($itemselec->anomdelo_id != 1): ?>
                                <?php
                                    if(isset($detalhes) && $index >= count($detalhes)) {
                                        $index = 0;
                                    }
                                ?>
                                <div>
                                    <label for="DataInicio<?php echo e($itemselec->id); ?>">Data Início</label>
                                    <input type="date"
                                        name="DataInicio[]"
                                        id="DataInicio<?php echo e($itemselec->id); ?>"
                                        class="form-control DataInicio"
                                        value="<?php echo e(isset($tabelaItem) && $tabelaItem->periodepagamento != 1 ? $detalhes[$index]->inicio : ''); ?>"
                                        required>

                                    <label for="DataFim<?php echo e($itemselec->id); ?>">Data Fim</label>
                                    <input type="date"
                                        name="DataFim[]"
                                        id="DataFim<?php echo e($itemselec->id); ?>"
                                        class="form-control DataFim"
                                        value="<?php echo e(isset($tabelaItem) && $tabelaItem->periodepagamento != 1 ? $detalhes[$index]->limite : ''); ?>"
                                        required>
                                </div>
                                <?php $index++; ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const mesesComDados = <?php echo json_encode(isset($MesescomDados) ? $MesescomDados->pluck('mes_id') : [], 15, 512) ?>;
    const selectElement = document.getElementById('tipoSelect');
    const cards = document.querySelectorAll('.card-ele');

    function updateCards(selectedValue) {
        cards.forEach(card => {
            const cardTipo = card.getAttribute('data-tipo');
            if (cardTipo === selectedValue) {
                card.style.display = 'block';
                enableFields(card);
            } else {
                card.style.display = 'none';
                disableFields(card);
            }
        });
    }

    function disableFields(card) {
        const inputs = card.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.disabled = true;
        });
    }

    function enableFields(card) {
        const inputs = card.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (input.type === 'checkbox' && mesesComDados.includes(Number(input.value))) {
                input.disabled = true;
            } else {
                input.disabled = false;
            }
        });
    }

    if (selectElement.value) {
        updateCards(selectElement.value);
    } else {
        const firstOption = selectElement.querySelector('option');
        if (firstOption) {
            selectElement.value = firstOption.value;
            updateCards(firstOption.value);
        }
    }

    selectElement.addEventListener('change', function () {
        updateCards(this.value);
    });
});
</script>
<?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/Componetes/modalidade-pagamento.blade.php ENDPATH**/ ?>
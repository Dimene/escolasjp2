
<input type="hidden" name="idprofessor" value="{{$id}}">
@foreach ($classe_turma as $turma)

    @php
        $checked = $tumasprofessor->contains('turma_id', $turma->id);
    @endphp
    <li class="list-group-item d-flex justify-content-between align-items-center turma-item" data-turma-id="{{ $turma->id }}">
        <div class="form-check">
            <input class="form-check-input turma-checkbox" type="checkbox"
                   value="{{ $turma->id }}"
                   name="turmasid[]"
                   id="turma_{{ $turma->id }}"
                   {{ $checked ? 'checked' : '' }}>
            <label class="form-check-label {{ $checked ? 'text-success fw-bold' : '' }}"
                   for="turma_{{ $turma->id }}">
                {{ $turma->Descricao }}
            </label>
        </div>
        @if ($checked)
            <span class="badge bg-warning text-dark atribuido-badge">Atribuído</span>
        @endif



    </li>
@endforeach

  <div class="bg-light p-2 border-top text-right" id="detailFooter" >
                                    <button class="btn btn-sm btn-primary" id="btnSalvarTurmas" type="button">
                                        <i class="fas fa-save"></i> Salvar Alterações
                                    </button>
                                </div>
<script>
    // Passar os IDs das turmas atribuídas para JavaScript

$(document).on("click", ".turma-checkbox", function() {
    const $checkbox = $(this);
    const turmaId = $checkbox.val();
    const isChecked = $checkbox.is(":checked");
    const $li = $checkbox.closest('li.turma-item');
    const $label = $li.find('label.form-check-label');
    let $badge = $li.find('.atribuido-badge');

    if (isChecked) {
        $label.addClass('text-success fw-bold');
        if ($badge.length === 0) {
            $badge = $('<span class="badge bg-warning text-dark atribuido-badge">Atribuído</span>');
            $li.append($badge);
        }
    } else {
        $label.removeClass('text-success fw-bold');
        $badge.remove();
    }
});

</script>
<!-- Adicione no final da view -->

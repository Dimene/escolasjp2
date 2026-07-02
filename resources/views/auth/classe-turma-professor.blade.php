<div class="col-md-12">
    <hr>
    <center>
        <label>As Disciplinas e Turmas</label>
    </center>
</div>

{{-- Campos ocultos --}}
<input type="hidden" class="idaluno" value="{{ $id }}">
<input type="hidden" class="anolectivo" value="{{ $ano }}">
<input type="hidden" class="classe_id" value="{{ $classes->id ?? 0 }}">

{{-- Select de Disciplinas --}}
<div class="col-md-12">
    <select class="form-control controler-disciplinas" id="select-disciplinas" name="disciplina_id">
        @foreach ($disciplinasFormatadas as $disciplina)
            @php
                $ignorarSelected = [0, 100];
                $isSelecionado = !in_array($disciplina['id'], $ignorarSelected)
                    && $tumasprofessor->contains('disciplina_id', $disciplina['id']);
            @endphp
            <option value="{{ $disciplina['id'] }}" {{ $isSelecionado ? 'selected' : '' }}>
                {{ $disciplina['Descricao'] }}
            </option>
        @endforeach
    </select>
</div>

{{-- Lista dinâmica de professores/turmas --}}
<div class="col">
    <ul class="list-group listaselecioadas">
        {{-- Conteúdo será carregado via Ajax --}}
    </ul>
</div>

{{-- Scripts --}}
<script src="{{ asset('Datatable/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('Datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('Datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('Datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('Datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('Datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.colVis.min.js') }}"></script>
<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>

<script>
    $(document).ready(function () {
        controlarVisibilidadeLista();
        carregarDisciplinasSelecionadas();

        $(".controler-disciplinas").on("change", function () {
            controlarVisibilidadeLista();
            carregarDisciplinasSelecionadas();
        });
    });

    // Função para esconder a lista se disciplina == 0
    function controlarVisibilidadeLista() {
        const disciplinaSelecionada = $(".controler-disciplinas").val();
        if (disciplinaSelecionada == 0) {
            $(".listaselecioadas").hide();
        } else {
            $(".listaselecioadas").show();
        }
    }

    // Função para buscar os professores vinculados à disciplina selecionada
    function carregarDisciplinasSelecionadas() {
        const aluno      = $(".idaluno").val();
        const classe     = $(".classe_id").val();
        const ano        = $(".anolectivo").val();
        const disciplina = $(".controler-disciplinas").val();

        const url = `/RegistoAcademico/turma/atriburi/professores/professoresselect/ckeck/${aluno}/${classe}/${ano}/${disciplina}`;

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $(".listaselecioadas").html('<li class="list-group-item">Carregando...</li>');
            },
            success: function (data) {
                $(".listaselecioadas").html(data);
            },
            error: function () {
                $(".listaselecioadas").html('<li class="list-group-item text-danger">Erro ao carregar dados.</li>');
            }
        });
    }
</script>

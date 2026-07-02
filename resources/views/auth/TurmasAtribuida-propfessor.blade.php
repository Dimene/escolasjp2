<form>
    <h4>Atribui&ccedil;&atilde;o de turmas</h4>

    <input value="{{ $id }}" class="idprofefessor" type="hidden">
    <div class="row">
        <div class="col">
            <label>selecione a classe</label>

            <select class="classes selectcotrol  form-control">
                @foreach ($classe as $classeItem)
                    <option value="{{ $classeItem->id }}"
                        @foreach ($tumasprofessor as $item)

                        @if ($item->classe_id == $classeItem->id)
                        selected @endif @endforeach>
                        {{ $classeItem->Descricao }}
                    </option>
                @endforeach

            </select>

        </div>
        <div class="col">
            <label>Selecione o Ano lectivo</label>
            <select class="anolectivo selectcotrol form-control">
                @foreach ($anoLectivo as $anoLectivoItem)
                    <option value="{{ $anoLectivoItem->id }}">
                        {{ $anoLectivoItem->anolectivo }}
                    </option>
                @endforeach

            </select>

        </div>


    </div>

    <div class="row Tabelaturmaprofessores_dados">

    </div>

    <div class="row ">
        <div class="col-md-8">


        </div>
        {{-- <div class="col">
            <button class="btn btn-primary Atribuir_professor_turma" type="button">Atualizar</button>

        </div> --}}

    </div>

</form>

<script>
    $(document).ready(function() {
        buscasr_professores_turma($(".idprofefessor").val(), $(".classes").val(), $(".anolectivo").val());

    });


    $(document).on("change", ".selectcotrol", function() {

        buscasr_professores_turma($(".idprofefessor").val(), $(".classes").val(), $(".anolectivo").val());


    })




    function buscasr_professores_turma(id, classe, ano) {
        $.ajax({
            url: '/RegistoAcademico/turma/atriburi/professores/professoresselect/' + id + '/' + classe + '/' +
                ano + '',
            type: 'get',

            beforeSend: function() {
                $(".Tabelaturmaprofessores_dados").html(
                    ' <img src="{{ asset('imageproceaament/loading.gif') }}"  style=" margin:auto;width:200px;height:200px">'
                );
                //$(".Tabelaturmaprofessores_dados").empty();

            },
            success: function(data) {
                $(".Tabelaturmaprofessores_dados").html(data);
            },

        });

    }
</script>



        $(document).ready(function() {


            $("#" + $("[name='turma_idController']").val() + "").addClass("active");

            $dsip = $('#displina_iddados').attr('title');
            $('[name="disciplina_id"]').val($('#displina_iddados').val());

            classe = $("#my-classe").val();
            ano = $("#my-anolectivo").val();
            buscar_turmas(ano, classe);

            $array = "<?php echo $preshow[0]->turma_id; ?>";
            console.log($array);
            console.log($dsip);
        });

        $(document).on('change', ".controler-classe-ano", function() {
            $(".Conteudotabela").empty();
            $(".conteudonotas").empty();
            classe = $("#my-classe").val();
            ano = $("#my-anolectivo").val();
            buscar_turmas(ano, classe);
            $(".Conteudotabela").empty("");
            $("#" + $("[name='turma_idController']").val() + "").addClass("active");
            $(".Conteudotabela").empty("");
            $(".conteudonotas").empty();
        });

        $(document).on('change', "[name='divisao_aolectivo']", function() {
            $(".Conteudotabela").empty("");
        });

        $(document).on('click', ".fa-edit-document", function() {
            jQuery.noConflict();
            $("#fa-edit-tabela").modal("show");
        });

        $(document).on("click", "#bt-prova", function() {
            $("#td" + $(this).attr("idprova") + "").addClass("mudarCor");
        });

        $(document).on('click', ".list-group-item", function(e) {
            if ($(this).attr('id') != undefined) {
                $("[name='turma_idController']").val($(this).attr('id'));
                buscarDivisano($("[name='turma_idController']").val());
                buscarnotas($("[name='turma_idController']").val(),
                    $("[name='divisao_aolectivo']").val());
            }
        });

        $(document).on("click", ".fa-cog", function() {
            $(".config-item").toggle("slow");
            $(".conteudo-confiDiv").toggleClass("mudarCor");
        });

        $(document).on("click", ".config-item", function() {

           let nome = $(this).attr("nome-modal");
    let modal = new bootstrap.Modal(document.getElementById(nome));
    modal.show();
        });

        $(document).on("click", ".config-item-Div", function() {
            $nome = $(this).attr("nome-modal");

            if ($nome == "adicionarCampoNotas") {
                if ($('#input-nomeprova').val() != "") {
                    $id_turma = $("#id-turma").val();
                    $.ajax({
                        url: '/RegistoAcademico/notas/' + $id_turma + '/edit',
                        type: 'GET',
                        success: function(data) {}
                    })
                }
            }
            fechamentoModel();
        });

        function fechamentoModel() {


                   let nome = $(this).attr("nome-modal");
    let modal = new bootstrap.Modal(document.getElementById(nome));
    modal.hide();
        }

        $(document).on("click", ".Turma-elemento", function() {
            $(".Turma-elemento").removeClass('active');
            $(this).addClass('active');
            buscarDivisano($("[name='turma_idController']").val());
            $(".Conteudotabela").empty();
            buscarnotas($("[name='turma_idController']").val(),
                $("[name='divisao_aolectivo']").val());
        });

        $(document).on('click', ".apagar-notaavaliacao", function() {
            $turma = $(this).attr('turma_id');
            $trimestre = $(this).attr('trimestre');
            $disciplina = $(this).attr('disciplina_id');
            $provaid = $(this).attr('provaid');

            let $ml = '<h5><i class="fa fa-warning" aria-hidden="true">Pretedes apagar' + $(this).text() +
                '</i></h5>' +
                '<hr><div class="row"><div class="col-6">' +
                '<button  class="btn btn-primary apagar-notaavaliacaodados" ' +
                'turma_id="' + $turma + '"' +
                'trimestre="' + $trimestre + '"' +
                'disciplina_id="' + $disciplina + '"' +
                'provaid="' + $provaid + '">' +
                'Sim</button></div>' +
                '<div class="col-6"><button  class="btn btn-danger naoApagar-notaavaliacao">nao</button></div></div>'
            $(".conteudo_alert_iformacao").html($ml);
            jQuery.noConflict();
            $("#modalalert").modal("show");
        });

        $(document).on('click', ".naoApagar-notaavaliacao", function() {
            jQuery.noConflict();
            $("#modalalert").modal("hide");
        });







        $(document).on('click', ".apagar-notaavaliacaodados", function() {
            jQuery.noConflict();
            $("#modalalert").modal("hide");
            $turma = $(this).attr('turma_id');
            $trimestre = $(this).attr('trimestre');
            $disciplina = $(this).attr('disciplina_id');
            $provaid = $(this).attr('provaid');

            console.log($turma, $trimestre, $disciplina, $provaid);
            $.ajax({
                url: "/RegistoAcademico/notas/disciplinas/apagarnota/" + $turma + "/" + $trimestre + "/" +
                    $provaid + "/" + $disciplina + "",
                type: 'Get',
                datatype: 'json',
                success: function(data) {
                    if (data.mensagem == "success") {
                        buscarnotasportrimestreturma($disciplina, $turma, $trimestre)
                    }
                }
            })
        });

        function buscarDivisano($turma) {
            $.ajax({
                url: '/RegistoAcademico/notas/' + $turma,
                type: 'GET',
                beforeSend: function() {
                    $(".conteudonotas").html(
                        '<div class="loading-container"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                    );
                },
                success: function(data, textStatus, jqXHR) {
                    $(".ConteudoDivisao").html(data);
                }
            });
        }

function buscarnotas($turma, $trimestre) {
    $(".conteudonotas").empty();

    $.ajax({
        url: '/RegistoAcademico/notas/turmasAlunos/' + $turma + '/' + $trimestre,
        type: 'GET',
        beforeSend: function () {

            $(".conteudonotas").empty();
            $(".conteudonotas").html(
                '<div class="loading-container text-center p-3">' +
                    '<div class="spinner-border text-primary" role="status">' +
                        '<span class="sr-only">Carregando...</span>' +
                    '</div>' +
                    '<p class="mt-2">Carregando notas...</p>' +
                '</div>'
            );
        },
        success: function (data) {
            $(".conteudonotas").html(data);

            // Alerta de sucesso (toast)
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Notas carregadas com sucesso!",
                showConfirmButton: false,
                timer: 1500
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".conteudonotas").html(""); // limpa spinner se falhar

            Swal.fire({
                icon: "error",
                title: "Erro ao carregar notas",
                text: "Por favor, tente novamente mais tarde.",
                confirmButtonText: "OK"
            });
        }
    });
}


        function buscarnotasportrimestreturma(disciplia, $turma, $trimestre) {
            $.ajax({
                url: '/RegistoAcademico/notas/elemento/' + disciplia + '/' + $turma + '/' + $trimestre,
                type: 'GET',
                beforeSend: function() {
                    $(".Conteudotabela").html(
                        '<div class="loading-container"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                    );
                },
                success: function(data, textStatus, jqXHR) {
                    $(".Conteudotabela").html(data);
                   // $(".butoes-controlo-notas").show("slow");
                }
            })
        }

        $(document).on('click', '.disciplina_id', function() {
            $dsip = $(this).attr('title');
            $('[name="disciplina_id"]').val($(this).attr('iddisp'));
            buscarnotasportrimestreturma($dsip, $('#turmaid').val(), $("[name='divisao_aolectivo']").val())
        });

        $(document).on("click", ".btn-guardar-nomeprova", function() {
            $(".butoes-controlo-notas").hide("slow");
            $("conteudo-confiDiv").hide("slow");
            $.ajax({
                url: '/RegistoAcademico/notas/elementoAddavaliacao/' + $("[name='disciplina_id']").val() +
                    '/' + $("[name='turma_idController']").val() +
                    '/' + $("[name='divisao_aolectivo']").val(),
                type: 'GET',
                dataType: 'json',
                data: {
                    'label': $("[name='labelavalicacao']").val()
                },
                beforeSend: function() {
                    $(".Conteudotabela").html(
                        '<div class="loading-container"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                    );
                },
                success: function(data, textStatus, jqXHR) {
                    buscarnotasportrimestreturma(
                        data.disciplina,
                        data.turma,
                        data.trimestre);
                }
            });
        });

        $(document).on('click', ".btn-calcular-media", function() {
            jQuery.noConflict();
            $("#criarFormula").modal("show");
        });

        $(document).on('click', ".btn-avaliacaofeitas", function() {
            $variavel = $("[name='formmulacriada']").val() + $(this).text();
            $("[name='formmulacriada']").val($variavel);
        });


        $(document).on('click', ".btn-guadarformulamedia", function() {
            jQuery.noConflict();
            $("#criarFormula").modal("hide");

        });

        function calculoMedia(dadoselementos) {
            console.log(dadoselementos);
            $dadosarra = [];
            dadoselementos.forEach(function(e) {
                    var media = math.evaluate(e.media);
                    var $mediaprecisao = math.format(media, 3);

                    $decimaldamedia = parseFloat($mediaprecisao) - parseInt($mediaprecisao);

                    if ($decimaldamedia > 0.45) {
                        $mediaprecisao = (parseInt($mediaprecisao) + 1);
                    } else {
                        $mediaprecisao = parseInt($mediaprecisao);
                    }
                    e["media"] = ($mediaprecisao);
                    $dadosarra.push(e);
                }
            );

            var token = '{{ Session::token() }}';
            $.ajax({
                url: '/RegistoAcademico/notas/disciplinas/guadarMedia',
                type: 'Post',
                dataType: 'json',
                data: {
                    "dados": $dadosarra,
                    "_token": token
                },
                success: function(data) {
                    buscarnotasportrimestreturma(
                        data.disciplina,
                        data.turma,
                        data.trimestre);
                }
            })
        }

        function buscar_turmas(ano, classe) {
            $.ajax({
                url: '/RegistoAcademico/notas/' + ano + '/' + classe + '',
                type: "GET",
                success: function(data, textStatus, jqXHR) {
                    $(".lista-Turmas").html(data);
                    $("[name='turma_idController']").val($("[key='0']").attr('id'));
                    $("[key='0']").addClass('active');
                    $dsip = $('#displina_iddados').attr('title');
                }
            });
        }

        $(document).on('click', '.guadardadosprova', function() {
            $.ajax({
                success: function(data) {
                    if (data.alert === "success") {
                        $(".informensage").fadeIn();
                        $(".informensage").addClass("alert");
                        $(".informensage").addClass("alert-success");
                        $(".informensage").text(data.Msg);
                        $(".informensage").fadeOut(2500);
                    }
                },
                url: '/RegistoAcademico/notas/disciplinas/guadardadosprova/' + $(
                        "[name='turma_idController']").val() + '/' + $("[name='divisao_aolectivo']").val() +
                    '/' +
                    $('#my-anolectivo').val() + '/' + $('#my-classe').val() + '/' + $(
                        '[name="disciplina_id"]').val() + "",
                type: 'Post',
                dataType: 'json',
                data: {
                    "_token": $("[name='_token']").val(),
                    'dados': $array,
                }
            })
        });



$(document).on("click", "#btnSaveFormula", function () {
    var $btn = $(this);
    var newFormula = $('#formulaInput').val();

    if (!newFormula) {
        showAlert("Insira uma fórmula válida", "danger");
        return;
    }

    // Ativar spinner e desabilitar botão
    $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...');
    $btn.prop("disabled", true);
      jQuery.noConflict();

   $.ajax({
    url: '/RegistoAcademico/notas/disciplinas/guadarformulamedias/' +
        $("[name='turma_idController']").val() + '/' +
        $("[name='divisao_aolectivo']").val() + '/' +
        $('#my-anolectivo').val() + '/' +
        $('#my-classe').val() + '/' +
        $('[name="disciplina_id"]').val(),
    type: 'POST',
    data: $("#formulaForm").serialize(),
    success: function (response) {

         $(".Conteudotabela").html(response);
      //  $("#formulaModal .modal-footer button[data-dismiss='modal']").trigger("click");

        // Swal.fire({
        //     position: "top-end",
        //     icon: "success",
        //     title: "Fórmula guardada com sucesso",
        //     showConfirmButton: false,
        //     timer: 2000
        // });


        // buscarnotas(
        //     $("[name='turma_idController']").val(),
        //     $("[name='divisao_aolectivo']").val()
        // );
// $('#formulaModal').modal('hide');

    // Disparar clique no <a> que tem a disciplina correspondente
   // $("a.disciplina_id[iddisp='" + response[0].disciplina + "']").trigger("click");

       //buscarnotasportrimestreturma( response[0].disciplina,  $("[name='turma_idController']").val(),  $("[name='divisao_aolectivo']").val())

    },
    error: function (xhr) {
        console.log(xhr.responseText); // veja exatamente o que o backend retornou
        Swal.fire({
            icon: "error",
            title: "Erro ao salvar fórmula",
            text: "Por favor, tente novamente.",
            confirmButtonText: "OK"
        });
    },
    complete: function () {
        $btn.html('<i class="fas fa-save"></i> Salvar Fórmula');
        $btn.prop("disabled", false);
    }
});









$('#btnSaveAll').on('click', async function () {

let btn = $(this);
    // Mostra todos os registros
    table.page.len(-1).draw();

    let alunoIds = [];
    let dados = table.rows().data().toArray();
    let i = 0;

    // Percorre todas as linhas do DataTable (mesmo as não visíveis)
    table.rows().every(function () {
        let id = $(this.node()).data('aluno-id');
        if (id !== undefined) {
            alunoIds.push(id);
            if (dados[i]) {
                dados[i][0] = id; // substitui a 1ª coluna pelo ID
            }
        }
        i++;
    });

    console.log("IDs capturados:", alunoIds);
    console.log("Dados enviados:", dados);

    // Enviar via Ajax
    $.ajax({
        url: "{{ route('notas.store') }}",
        type: "POST",
        dataType: "json",
        data: {
            _token: "{{ csrf_token() }}",
            dados: dados,
            avaliacoes:  avaliacoesdados,
            turma: @json($turmaid),
            divisao: $("[name='divisao_aolectivo']").val(),
            anolectivo: $('#my-anolectivo').val(),
            classe: $('#my-classe').val(),
            disciplina:@json($iddisciplia)
        },
        beforeSend: function () {
            console.log("Enviando dados...");
            btn.find(".spinner-border").removeClass("d-none");
    btn.find(".btn-text").text("Salvando...");
     btn.prop("disabled", true);

        },
        success: function (response) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "atualizado com sucesso",
                showConfirmButton: false,
                timer: 2000
            });

            // Atualiza notas sem recarregar página
            // buscarnotas(
            //     $("[name='turma_idController']").val(),
            //     $("[name='divisao_aolectivo']").val()

            // );


             buscarnotasportrimestreturma(response.disciplina,  $("[name='turma_idController']").val(),
             $("[name='divisao_aolectivo']").val());

			 btn.find(".spinner-border").addClass("d-none");
        btn.find(".btn-text").text("Salvar Tudo");
        btn.prop("disabled", false);
        },
        error: function (xhr) {
            console.error("Erro:", xhr.responseText);
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Erro ao salvar os dados!",
                showConfirmButton: false,
                timer: 2000
            });
        },
        complete: function () {
            // Sempre volta para 25 registros por página
            table.page.len(25).draw();
        }
    });
});





    var  avaliacoesdados= @json($disciplinaavalaicaotipo[$iddisciplia]);
    var table = $('#editableTable').DataTable({
        pageLength: 25,
        language:{
                url: "/Datatable/pt/Portuguese-Brasil.json"
        }
    });

    // Fórmula vinda do banco
    var formula = "{{ !empty($formunlamendia) ? $formunlamendia->formula : '' }}";
    var changes = {};
    var columnMap = {};

    // Mapeia colunas para substituir variáveis
    @foreach ($disciplinaavalaicaotipo[$iddisciplia] as $index => $dispv)
        @if ($dispv->nota_meta_id != 0)
            columnMap[{{ $index + 2 }}] = { id: "{{ $dispv->nota_meta_id }}", desc: "{{ $dispv->nota_descricao }}" };
        @endif
    @endforeach

    // Função para exibir alertas flutuantes
    function showAlert(message, type){
        var alert = type==='success'?$('#successAlert'):$('#errorAlert');
        alert.removeClass('alert-success alert-danger').addClass('alert-'+type).text(message).fadeIn();
        setTimeout(()=>alert.fadeOut(),3000);
    }

    // Função que calcula e atualiza a média de um aluno
    function updateMedia(linha){
        if(!formula) return;


        var formulaToCalculate = formula;


$dados=table.row(linha).data();
$array=[];
$arrayDados=[];
let avaliacaoMap = {};
avaliacoesdados.forEach(function(e,index){
    $array.push(e.nota_descricao);
    $arrayDados.push($dados[index+3]);

    avaliacaoMap[e.nota_descricao] =$dados[index+3];
});
        console.log($dados,$array,$arrayDados,formulaToCalculate,avaliacaoMap);
        let formulaCalculada = formulaToCalculate;

        for (let nome in avaliacaoMap) {
    // substitui todas as ocorrências do nome pela nota
    let regex = new RegExp("\\b" + nome + "\\b", "g");
    formulaCalculada = formulaCalculada.replace(regex, avaliacaoMap[nome]);
}

console.log("Fórmula original:", formulaToCalculate);
console.log("Fórmula substituída:", formulaCalculada);

// Se quiser calcular:
let resultado = eval(formulaCalculada);
let parteInteira = Math.floor(resultado);
let parteDecimal = resultado - parteInteira;

let resultadoFinal = (parteDecimal > 0.4)
    ? Math.ceil(resultado)
    : Math.floor(resultado);

console.log("Resultado bruto:", resultado);
console.log("Resultado arredondado:", resultadoFinal);
$dados[$dados.length-1]=resultadoFinal;
console.log($dados);

 // Atualiza a linha no DataTable
    table.row(linha).data($dados).draw(false);
    }

    // Edição inline
    $('#editableTable').on('click','td.editable',function(){
        if($(this).find('input').length) return;

        var cell = $(this);
        var value = cell.text().trim();
        var alunoId = cell.data('aluno');
        var alunoIdCelula = cell.attr('id');
        var avaliacaoId = cell.data('avaliacao');
        var avaliacaoValor = cell.attr('avaliacaobvalor');
        var avaliacaoIdNome = cell.data('avaliacaonome');
        var idnota = cell.data('idnota');

        cell.html('<input type="text" class="form-control form-control-sm" value="'+
        value+'" data-aluno="'+alunoId+
        '" data-avaliacao="'+avaliacaoId+
        '" data-idnota="'+idnota+'">');
        var input = cell.find('input');
        input.focus().select();

        // Ao sair do input ou pressionar ENTER
        input.on('blur keydown', function(e){
            if(e.type==='blur' || e.key==='Enter'){
                var newValue = input.val().trim();

                // Validação entre 0 e 20
                if(newValue && !/^([0-9]|1[0-9]|20)(\.[0-9]{1,2})?$/.test(newValue)){
                    showAlert("Valor inválido! Use números entre 0 e 20.","danger");
                    input.focus();
                    return;
                }

                // Atualiza DataTable
                var pos = table.cell(cell).index();
                table.cell(pos.row, pos.column).data(newValue).draw(false);

                // Destaque visual
                cell.addClass('highlight');
                setTimeout(()=>cell.removeClass('highlight'), 1000);
                console.log(""+avaliacaoIdNome+"",newValue,alunoIdCelula,pos.row, pos.column);
        $("#"+alunoIdCelula+"").attr("avaliacaobvalor",newValue);
cell.data("avaliacaonome",newValue);
                // Registra alteração
                changes[alunoId] = changes[alunoId] || {};
                changes[alunoId][avaliacaoId] = { value: newValue, idnota: idnota };

                // Atualiza a média
                updateMedia(pos.row);


            } else if(e.key==='Escape'){
                cell.text(value);
            }
        });

        // Navegação com TAB e setas
        input.on('keydown',function(e){
            var pos = table.cell(cell).index();
            var rowIdx = pos.row, colIdx = pos.column;
            var totalRows = table.rows().count(),
                totalCols = table.columns().count();

            switch(e.keyCode){
                case 9: // Tab
                    e.preventDefault();
                    if(!e.shiftKey){
                        colIdx++;
                        if(colIdx>=totalCols){ colIdx=2; rowIdx++; }
                    } else {
                        colIdx--;
                        if(colIdx<2){ colIdx=totalCols-1; rowIdx--; }
                    }
                    break;
                case 37: colIdx--; break; // Esquerda
                case 39: colIdx++; break; // Direita
                case 38: rowIdx--; break; // Cima
                case 40: rowIdx++; break; // Baixo
            }

            if(rowIdx>=0 && rowIdx<totalRows && colIdx>=2 && colIdx<totalCols)
                table.cell(rowIdx,colIdx).node().click();
        });
    });

    // Inserir variável na fórmula
    $('.btn-insert-var').click(function(){
        var input = $('#formulaInput');
        var pos = input[0].selectionStart;
        var val = input.val();
        input.val(val.substring(0,pos) + $(this).data('var') + val.substring(pos)).focus();
    });



    // Excluir coluna
    $('.delete-column').click(function(){
        if(!confirm('Deseja excluir esta avaliação?')) return;
        showAlert("Avaliação excluída com sucesso!","success");
        setTimeout(()=>location.reload(),1500);
    });

});




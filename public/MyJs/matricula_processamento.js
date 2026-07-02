
  const urls = {
        matriculaStore: "/aluno/matricula/store",
        selecionarValores: "/aluno/matricula/selecionar_tabelaValores/",
        imprimirRecibo: "/aluno/matricula/imprimir/recibo/",
    };
$(document).ready(function () {
    // URLs centralizadas


    // Evento para exibir o modal
    $(".botaoAtualizacaoAlunoId").on("click", function () {
        selecionar_tabelavalores(
            $("[name='ClassedeAtualizacao']").val(),
            $(".anolectivo").val(),
            2
        );



        //adiconar dados



        const modal = new bootstrap.Modal(document.getElementById("exampleModal"));
        modal.show();
    });

    // Evento para salvar dados
    $(".btn-guardar").click(function (e) {
        e.preventDefault();

        // Validação de campos
        const isValid =
            validarCampo("[name='NomeAluno']", "#NomeAluno_Info") &
            validarCampo("[name='NomeDoenca']", "#NomeDoenca_Info") &
            validarCampo("[name='nomeEncaregado']", "#nomeEncaregado_Info") &
            validarCampo("[name='profisaoEncaregado']", "#profisaoEncaregado_Info") &
            validarCampo("[name='DataNascimento']", "#DataNascimento_Info") &
            validarCampo("[name='contacto[]']", "#contacto_Info") &
            validarCampo("[name='Bairo']", "#Bairo_Info") &
            validarCampo("[name='RuaAvenida']", "#RuaAvenida_Info") &
            validarCampo("[name='casaNumero']", "#casaNumero_Info") &
            validarCampo("[name='Quarterao']", "#Quarterao_Info");

        if (isValid) {
            selecionar_tabelavalores(
                $(".classe_matricula").val(),
                $(".anolectivo_Matricula").val(),
                1
            );
            const modal = new bootstrap.Modal(document.getElementById("exampleModal"));
            modal.show();
            $(".imgprocessar").hide("slow");
            $(".conteudo").show("slow");
        }

let tipoPagamento = $(".idtipopagamento").val();

if (tipoPagamento == 0 || tipoPagamento === "0") {
    $(".Btn-guardarMatricula").hide();
}    });

    // Evento para confirmar matrícula
    $(document).on("click", ".Btn-guardarMatricula", function () {
        Matricular();
    });

    // Função para processar a matrícula
    function Matricular() {
        const $contacto = [
            $(".cont1").val(),
            $(".cont2").val(),
            $(".cont3").val(),
        ];
const multaCheckbox = $("[name='multaActiva']");
const multaValue = multaCheckbox.is(":checked") ? multaCheckbox.val() : 0;

        const formData = new FormData();
        formData.append("_token", token);
        formData.append("Bairo", $("[name='Bairo']").val());
        formData.append("religiaoAluno", $("[name='religiaoAluno']").val());
        formData.append("nomeEncaregado", $("[name='nomeEncaregado']").val());
        formData.append("anolectivo", $("[name='anolectivo']").val());
        formData.append("estadoSaude", $("[name='estadoSaude']").val());
        formData.append("Graouparentesco", $("[name='Graouparentesco']").val());
        formData.append("contacto[]", $contacto);
        formData.append("ReligiaoEncaregado", $("[name='ReligiaoEncaregado']").val());
        formData.append("sexoEncaregado", $("[name='sexoEncaregado']").val());
        formData.append("RuaAvenida", $("[name='RuaAvenida']").val());
        formData.append("NomeDoenca", $("[name='NomeDoenca']").val());
        formData.append("TipoAluno", $("[name='TipoAluno']").val());
        formData.append("sexoAluno", $("[name='sexoAluno']").val());
        formData.append("DataNascimento", $("[name='DataNascimento']").val());
        formData.append("Quarterao", $("[name='Quarterao']").val());
        formData.append("casaNumero", $("[name='casaNumero']").val());
        formData.append("classe", $("[name='classe']").val());
        formData.append("NomeAluno", $("[name='NomeAluno']").val());
        formData.append("numero", "0");
        formData.append("tipopagamento", $("[name='tipopagamento']").val());
        formData.append("multaAct", multaValue)
        formData.append("idtipopagamento", 1);

        const avatarFile = $("[name='avatar-file']")[0].files[0];
        if (avatarFile) {
            formData.append("avatar-file", avatarFile);
        }

        $.ajax({
            url: urlstore,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".conteudo").hide("slow");
                $(".imgprocessar").show("slow");
            },
            success: function (data) {
                if (data.mensagem === "Sucesso") {
                    printRecibo(data.idaluno, data.anolectivo);
                } else {
                    $(".imgprocessar").hide("slow");
                    $(".conteudo").show("slow");
                    $(".alert-danger").show("slow");
                    $(".MensagemError").html(data.Info);
                }
            },
        });
    }

    // Função para imprimir o recibo
    function printRecibo(id, ano) {
        const url = urls.imprimirRecibo + id + "/" + ano;

        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function () {
                $(".imgprocessar").show("slow").html("<h3>Aguarde Recibo...</h3>");
            },
            success: function (data) {
                $(".imgprocessar").hide("slow");
                $(".conteudo").show("slow");
                $("[name]").val("").css("border", "2px solid #dee2e6");

                const tela_impressao = window.open("about:blank");
                tela_impressao.document.write(data);
                tela_impressao.window.print();
                tela_impressao.window.close();

                // Recarregar página
                location.reload();
            },
        });
    }

    // Função para carregar valores na tabela
    function selecionar_tabelavalores(classe, ano, tipo) {


        $.ajax({
            url: `${urls.selecionarValores}${classe}/${ano}/${tipo}`,
            type: "GET",
            success: function (data) {
                $(".corpoConteudo").html(data);
            },
        });
    }

    // Função de validação de campos
    function validarCampo(campo, infoSelector) {
        if ($(campo).val() === "") {
            $(infoSelector).css("color", "red").show("slow");
            $(campo).css("border-color", "red");
            return false;
        } else {
            $(campo).css("border", "2px solid #dee2e6");
            $(infoSelector).hide("slow");
            return true;
        }
    }
});




       $(document).on("change", ".anolectivo_Matricula", function() {

        let classe= $("[name='ClassedeAtualizacao']").val();
           let ano= $(".anolectivo_Matricula").val();
            let tipo=1;
      $.ajax({
            url: `${urls.selecionarValores}${classe}/${ano}/${tipo}`,
            type: "GET",
            success: function (data) {
                $(".corpoConteudo").html(data);
            },
        });
});




 // VALIDAÇÃO VISUAL LEVE
    function validarCampos(){
        let valid = true;
        $('input[required], select[required]').each(function(){
          if($(this).val() === ''){
            $(this).css('border', '2px solid #dc3545');
            valid = false;
          } else {
            $(this).css('border', '');
          }
        });
        return valid;
    }

    $(document).on("click",'#btnMatricular',(function(){
        if(validarCampos()){

			$ano=  $("[ name='anoLectivo']").val();
  $classeId=  $("[ name='classe']").val();

			selecionar_tabelavalores(
			$classeId,
                $ano,
                1
            );
            $('#modalPagamentos').modal('show');
        } else {
            alert('Preencha todos os campos obrigatórios do aluno!');
        }
    });




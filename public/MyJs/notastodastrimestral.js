
var debounceTimer="" ;
    var $tabelatrimestral = "";
    //var $tabelatrimestral = "";
     var currentColIndex ="";
  urlmedia=   window.urlmedia;
urlTrancar=window.urlTrancar ;
urldadosTable=window.urldadosTable;
 arrayElementos=window.arrayElementos;
 rotaDadosTable=window.rotaDadosTable;
 trimestre=window.trimestre;
 classe_disciplinas=window.classe_disciplinas;
 vriavelFormulaMedia=window.vriavelFormulaMedia;
 flag=window.flag;
 classturma=window.classturma;
 tipoMedia=window.tipoMedia;

     var $dadosparaEnvio=[];
$(document).ready(function () {

inicializarDataTable();
inicializarEventListeners();

// capturando a pagina aberta do datatabler
$("#listadosalunos").on("page.dt", function () {
    paginaDatatable = $tabelatrimestral.page.info().page;
});



});


 $(document).on("click", ".btn-guadarformulamediaAnual ", function() {
                jQuery.noConflict();

                $("#criarFormulaMedia").modal("hide");
                let valorformula = $("[name='formmulacriadaParamedia']").val();
                if (valorformula != "") {
                    jQuery.noConflict();
                    $("#criarFormula").modal("hide");
                    guardaformulaAnual(2);
                } else {
                    alert("o campo Formula Nao deve estar Fazia");
                }
            });

 $(document).on("click", ".btn-guadarformulamedia ", function() {
                jQuery.noConflict();
                $("#criarFormula").modal("hide");
                let valorformula = $("[name='formmulacriada']").val();
                if (valorformula != "") {
                    jQuery.noConflict();
                    $("#criarFormula").modal("hide");
                    guardaformulatriemstral(vriavelFormulaMedia);
                    mediapordisciplinatodas();

                } else {
                    alert("o campo Formula Nao deve estar Fazio");
                }
            });

  $(document).on("click", ".btn-fecharTRimestre", function() {
                jQuery.noConflict();
                $("#FecharTrimestre").modal("show");
            });


            $(document).on("click", ".MediaDisciplina", function() {
                jQuery.noConflict();
                $("#criarFormula").modal("show");
            });



            $(document).on("click", ".MediaAnual", function() {
                jQuery.noConflict();
                $("#criarFormulaMedia").modal("show");
            });




            $(document).on('click', ".btn-avaliacaofeitasMedia", function() {
    const $input = $("[name='formmulacriadaParamedia']");
    const dados = $(this).text().trim();
    let valorAtual = $input.val().trim();

    // Evita duplicar a mesma sigla consecutivamente
    if (!valorAtual.endsWith(dados)) {
        valorAtual += dados;
        $input.val(valorAtual.trim());
    }

    // Mantém o foco no campo de fórmula
    $input.focus();
});






            $(document).on("click", ".btn-fecharTRimestre", function() {
                jQuery.noConflict();
                $("#FecharTrimestre").modal("show");
            });


            $(document).on("click", ".MediaDisciplina", function() {
                jQuery.noConflict();
                $("#criarFormula").modal("show");
            });



            $(document).on("click", ".MediaAnual", function() {
                jQuery.noConflict();
                $("#criarFormulaMedia").modal("show");
            });


           // Em um arquivo JavaScript principal que carrega apenas uma vez
$(document).ready(function() {
    $(document).on('click', '.btn-avaliacaofeitas', function(e) {
        e.preventDefault();

        // Importante: declarar variáveis com var/let/const
        let $dados = ($(this).text().trim());
        let $variavel = $("[name='formmulacriada']").val().trim() + $dados;
        $("[name='formmulacriada']").val($variavel.trim());

        // Opcional: prevenir múltiplos cliques rápidos
        $(this).prop('disabled', true);
        setTimeout(() => {
            $(this).prop('disabled', false);
        }, 500);
    });
});
            // $(document).on('click', ".btn-avaliacaofeitas", function() {
            //     $dados = ($(this).text().trim());
            //     $variavel = $("[name='formmulacriada']").val().trim() + $dados;
            //     $("[name='formmulacriada']").val($variavel.trim());


            // });

            $(document).on('click', ".btn-avaliacaofeitasMedia", function() {
    const $input = $("[name='formmulacriadaParamedia']");
    const dados = $(this).text().trim();
    let valorAtual = $input.val().trim();

    // Evita duplicar a mesma sigla consecutivamente
    if (!valorAtual.endsWith(dados)) {
        valorAtual += dados;
        $input.val(valorAtual.trim());
    }

    // Mantém o foco no campo de fórmula
    $input.focus();
});
// guardar formula e guardar notas
            $(document).on("click", ".btn-guadarformulamedia ", function() {
                jQuery.noConflict();
                $("#criarFormula").modal("hide");
                let valorformula = $("[name='formmulacriada']").val();
                if (valorformula != "") {
                    jQuery.noConflict();
                    $("#criarFormula").modal("hide");
                    guardaformulatriemstral(1);
                } else {
                    alert("o campo Formula Nao deve estar Fazio");
                }
            });

// $(document).on("click", ".NotasPautaCaregar", function() {
//                 jQuery.noConflict();
//                 $("#criarFormula").modal("hide");
//                 let valorformula = $("[name='formmulacriada']").val();


//                if (valorformula != "") {
//                     jQuery.noConflict();
//                     $("#criarFormula").modal("hide");
//                     guardaformulatriemstral(1);
//                 } else {
//                     alert("o campo Formula Nao deve estar Fazio");
//                 }});


   function guardardados($linhac){



   }



            $(document).on("click", ".btn-guadarformulamediaAnual ", function() {
                jQuery.noConflict();

                $("#criarFormulaMedia").modal("hide");
                let valorformula = $("[name='formmulacriadaParamedia']").val();
                if (valorformula != "") {
                    jQuery.noConflict();
                    $("#criarFormula").modal("hide");
                    guardaformulaAnual(2);
                } else {
                    alert("o campo Formula Nao deve estar Fazia");
                }
            });

function atualizarProgresso(percent) {

    $("#progressBar")
        .css("width", percent + "%")
        .text(percent + "%");

}


            function guardaformulatriemstral($flag) {
                 $("#progressContainer").show();
                  atualizarProgresso(0);
  let disciplinaId=$(".disciplina_id.active").data("disciplina-id");
         let trimestre=$("#my-divisao").val();
          let liAtivo = document.querySelector(".turmaselecionada.active");
				$formula=$("[name='formmulacriada']").val();
			$("[name='formulaTri']").val($formula);

                $.ajax({
                    url: "/RegistoAcademico/notas/trimestre/guadarformulamedias/" + $flag + "",
                    type: "post",
                    dataType: "json",
                    data: {
                        "_token": $("[name='_token']").val(),
                        "formula":$formula,
                        "turma": liAtivo.id,
                        "anolectivo": $("[name='anolectivo']").val(),
                        "dados": "",
                        "dadosid": "",
                        "flagTempoMedia":window.tipoMedia


                    },

                    success: function(dados) {

                        if (dados.alert === "success") {




let contador = 0;
classe_disciplinas.forEach(function(e) {
    // console.log("Disciplina:", e.disciplina_id);


    let divisao ="";
    window.trimestre.forEach(function(e){
       if(e.divisao==1){
       divisao=e.divisao;

       }


    })
    let totalLinhas = $dadosparaEnvio.length; // `.count()` não existe em JS puro

    for (let x = 0; x < totalLinhas; x++) {
        let seletor = "table td[title='" + divisao + "NFDisp" + e.disciplina_id + "linha" + x + "']";
        let celula = $(seletor);
  celula.attr("formula",$("[name='formulaTri']").val());
        if (celula.length) {
            mediapordisciplina(celula);

			var linha = celula.closest('tr');
   var idAluno = linha.attr('dadosnota');


			// guardaLinhaBD(idAluno,organisarArraySava(linha));
        } else {
            console.warn("Célula não encontrada:", seletor);
        }
        contador++;

                        let percent = Math.round((contador / (totalLinhas * classe_disciplinas.length)) * 100);

                        atualizarProgresso(percent);
    }
});



                        //    buscar_turmaSelecionada(dados.turma);

                            $(".informensage").fadeIn();
                            $(".informensage").addClass("alert");
                            $(".informensage").addClass("alert-success");
                            $(".informensage").text(dados.Msg);
                            $(".informensage").fadeOut(2500);


                        }
                    }
                })

                setTimeout(function () {

                    atualizarProgresso(100);

                    setTimeout(function () {

                        $("#progressContainer").hide();

                    }, 1000);

                }, 300);


            }
function guardaformulaAnual($flag) {
    const formula = $("[name='formmulacriadaParamedia']").val();
    const formulaanual = formula; // atribui corretamente o valor

    $("[name='formulaanual']").val(formulaanual);
    let liAtivo = document.querySelector(".turmaselecionada.active");
    $.ajax({
        url: "/RegistoAcademico/notas/trimestre/guadarformulamedias/" + $flag,
        type: "post",
        dataType: "json",
        data: {
            "_token": $("[name='_token']").val(),
            "formula": formula,
            "turma": liAtivo.id,
            "anolectivo": $("[name='anolectivo']").val(),
            "flagTempoMedia":window.tipoMedia
        },
        success: function(dados) {
            if (dados.alert === "success") {
                $('#listadosalunos tbody tr').each(function() {
                    const $linha = $(this);
                    const $celula = $linha.children('td').eq(-2);

                    $linha.children('td').eq(-2).attr("formulamediafinal", formulaanual);
                    mediaAnual($celula); // aplica a função na célula correta
                    guardarmediaAnual($celula,tipoMedia); // aplica a função na célula correta
                    Resultado($celula); // aplica a função na célula correta

                });
            }
        }
    });
}




function guardarmediaAnual($celula,flag) {
    const $linha = $celula.closest('tr');
    const linhaIndex = parseInt($celula.attr("linha"));
    const colunaMediaIndex = $linha.children('td').eq(-2).index();
    const colunaResultadoIndex = $linha.children('td').last().index();

    const id = $linha.attr('dadosNota');
    const media = $dadosparaEnvio[linhaIndex]?.[colunaMediaIndex] || 0;
    const resultado = $dadosparaEnvio[linhaIndex]?.[colunaResultadoIndex] || "";

    // console.log("ID:", id, "Média:", media, "Resultado:", resultado);

    $.ajax({
        url: "/RegistoAcademico/notas/trimestre/guadarMediaAnual/"+flag,
        type: "post",
        dataType: "json",
        data: {
            "_token": $("[name='_token']").val(),
            "id": id,
            "media": media,
            "Resultado": resultado,
            "anolectivo": $("[name='anolectivo']").val()
        },
        success: function(dados) {
            // console.log("✅ Média anual guardada com sucesso:", dados);
        },
        error: function(err) {
            // console.error("❌ Erro ao guardar média anual:", err);
        }
    });
}


function Resultado($celula) {
    let resultado = "Aprovad";
    let areaReprovada = "";
    let disciplinasNotasResultado = []; // Armazena objetos com info da disciplina

    const $linha = $celula.closest("tr");
    const row = $tabelatrimestral.row($linha);
    const rowIndex = row.index();


    // sexo do aluno
    const sexo = $linha.find("td").eq(2).text().trim();

    // Percorrer médias das disciplinas
    $linha.find("td[siglaDisp]").each(function() {
        const sigla = $(this).attr("siglaDisp");
        const area = $(this).attr("area");
        const nota = parseFloat($(this).text().trim());

        if (sigla === "P" || sigla === "M") {
            if (nota <= 9.9) {
                disciplinasNotasResultado.push({ sigla, area, nota });
            }
        } else {
            if ((nota <= 9.9 &&sigla != "P") || (nota <= 9.9 &&sigla === "M")) {
                disciplinasNotasResultado.push({ sigla, area, nota });
            }
        }
    });

    // Regras de reprovação
    if (classturma.FormaTrasitar_id === 1 && disciplinasNotasResultado.length > 0) {

        if(disciplinasNotasResultado.some(d => d.sigla === "P")||disciplinasNotasResultado.some(d => d.sigla === "M")){
 resultado = "Reprovad";
        }
        else if(disciplinasNotasResultado.some(d => d.sigla!="P")||disciplinasNotasResultado.some(d => d.sigla!="M")){
            if(disciplinasNotasResultado.length>2){
 resultado = "Reprovad";

            }else if(disciplinasNotasResultado.some(d => d.nota<8)){

 resultado = "Reprovad";

            }



        }
         areaReprovada = "";

    } else if (classturma.FormaTrasitar_id === 2 && disciplinasNotasResultado.length > 0) {
        resultado = "Reprovad";

        const reprovouLetras = disciplinasNotasResultado.some(d => d.area === "2");
        const reprovouCiencias = disciplinasNotasResultado.some(d => d.area === "1");
        const reprovouTodas = disciplinasNotasResultado.some(d => d.area === "3");

        if ((reprovouLetras && reprovouCiencias) || reprovouTodas) {
            areaReprovada = "";
        } else if (reprovouLetras) {
            areaReprovada = " em Letras";
        } else if (reprovouCiencias) {
            areaReprovada = " em Ciências";
        }
    }else if (classturma.FormaTrasitar_id === 3 && disciplinasNotasResultado.length > 0) {
         resultado = "Reprovad";
           areaReprovada ="";

         disciplinasNotasResultado.forEach(function(e){
areaReprovada=areaReprovada+e.sigla+",";
         });



    }



    console.log("Resultado:", resultado, "Disciplinas reprovadas:", disciplinasNotasResultado, "Área:", areaReprovada);

   // return { resultado, areaReprovada };



    // genero
    const sufixo = sexo === "F" ? "a" : "o";
    const resultadoFinal = resultado + sufixo+" "+areaReprovada;

    // última célula da linha
    const $celulaResultado = $linha.find("td").last();
    const colunaResultado = $celulaResultado.index();

    // atualizar visual
    $celulaResultado
        .text(resultadoFinal)
        .css("color", resultado === "Aprovad" ? "green" : "red")
        .css("font-weight", "bold");

    // atualizar node interno do DataTable
    $tabelatrimestral.cell(rowIndex, colunaResultado).data(resultadoFinal);

    return resultadoFinal;
}

function inicializarDataTable() {


        $tabelatrimestral =$('#listadosalunos').DataTable({
        responsive: true,
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        lengthMenu: [
            [-1],
            ["Todos"]
        ],
        autoWidth: false,
        scrollY: "500px",
        scrollX: true,
        fixedColumns: {
            leftColumns: 2 // fixa 2 colunas da esquerda
        },
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
        },
        initComplete: function() {
            // 🔹 Fixar THEAD e TFOOT após inicialização
            new $.fn.dataTable.FixedHeader($tabelatrimestral, {
                header: true,
                footer: true,
                headerOffset: 0 // ajuste se tiver navbar fixa
            });
        }
    });


     $dadosparaEnvio = $tabelatrimestral.rows().data().toArray();
    }



function inicializarEventListeners() {






  $(document).on('keydown', '.colunaEditavel', function(e) {
            handleKeyboardNavigation(e, $(this));

        });


            $(document).on('blur', '.colunaEditavel', function() {
            clearTimeout(debounceTimer);
           guardarNodatatable( $(this));

            mediapordisciplina($(this));
             mediaAnual($(this));
const estado = $(".GereraResultado").attr("data-estado");
if(estado=== "on") {
    guardarmediaAnual($(this),tipoMedia); // aplica a função na célula correta
    Resultado($(this));         // aplica a função na célula correta
 }

			const linhas = document.querySelectorAll('table tr[dadosNota]');
			var linha = $(this).closest('tr');
   var idAluno = linha.attr('dadosnota');

//    let id = $(this.node()).data('id');
			//guardaLinhaBD(idAluno,organisarArraySava(linha));
            precistirBD(linha);

            debounceTimer = setTimeout(() => {


            }, 800);
        })


        let linhaAtual = null;
let colunaAtual = null;

$(document).on("focus click", ".colunaEditavel", function () {
    const $td = $(this).closest("td");
    linhaAtual = parseInt($td.attr("linha"));
    colunaAtual = parseInt($td.attr("coluna"));
});



// BAIXAR EXECEL PAULTA
$(document).on('click', '.BaixarExcel', function () {

    let corpo1 = $tabelatrimestral.rows().data().toArray();

 // Mostra todos os registros
    $tabelatrimestral.page.len(-1).draw();

    let corpo = [];
    let dados = $tabelatrimestral.rows().data().toArray();
    let i = 0;

    // Percorre todas as linhas do DataTable (mesmo as não visíveis)
     $tabelatrimestral.rows().every(function (e,index) {
        dadopush=[];
        let id = $(this.node()).data('id');
        if (id !== undefined) {
            dadopush.push(id);
            dados[i].forEach(function(e,index2){

 dadopush.push(e);
            })

corpo.push(dadopush);

        }
        i++;
    });
// console.log("IDs capturados:",  corpo);
    // console.log("Dados enviados:", dados);


    // console.log(corpo);
    $('#corpo').val(JSON.stringify(corpo));
    $('#disciplinas').val(JSON.stringify(classe_disciplinas));
    $('#trimestre').val(JSON.stringify(trimestre));
    $('#turma').val(turma);

    $('#formExcel').submit();

});
}


function handleKeyboardNavigation(e, $currentCell) {

    const $currentTd = $currentCell.closest('td');

    const currentColIndex = parseInt($currentTd.attr('coluna'));
    const currentRowIndex = parseInt($currentTd.attr('linha'));
// console.log($currentTd, currentRowIndex,currentColIndex);
    // todas as células editáveis
    const $allEditableCells = $('#listadosalunos').find('.colunaEditavel');
    const currentCellIndex = $allEditableCells.index($currentCell);

    switch (e.key) {
        case 'ArrowRight':
            e.preventDefault();
            if (currentCellIndex < $allEditableCells.length - 1) {
                focusCell($allEditableCells.eq(currentCellIndex + 1));
            }
            break;

        case 'ArrowLeft':
            e.preventDefault();
            if (currentCellIndex > 0) {
                focusCell($allEditableCells.eq(currentCellIndex - 1));
            }
            break;

        case 'ArrowDown':
        case 'Enter':
            e.preventDefault();
            navigateVertical(currentRowIndex, currentColIndex, 1); // descer
            break;

        case 'ArrowUp':
            e.preventDefault();
            navigateVertical(currentRowIndex, currentColIndex, -1); // subir
            break;

        case 'Tab':
            e.preventDefault();
            if (e.shiftKey) {
                if (currentCellIndex > 0) {
                    focusCell($allEditableCells.eq(currentCellIndex - 1));
                }
            } else {
                if (currentCellIndex < $allEditableCells.length - 1) {
                    focusCell($allEditableCells.eq(currentCellIndex + 1));
                }
            }
            break;
    }
}


function navigateVertical(rowIndex, colIndex, step) {
    const $table = $('#listadosalunos');
    const $allRows = $table.find('tbody tr:visible');
    let targetRow = rowIndex + step;

    while (targetRow >= 0 && targetRow < $allRows.length) {
        const $targetCell = $allRows.eq(targetRow)
            .find(`.colunaEditavel[coluna="${Number(colIndex)}"]`);

        if ($targetCell.length) {
            const $currentCell = $allRows.eq(rowIndex)
                .find(`.colunaEditavel[coluna="${Number(colIndex)}"]`);
            // guardarimput2($currentCell.find("input")); // se precisar salvar
            focusCell($targetCell);
            return;
        }
        targetRow += step;
    }

    console.warn('Nenhuma célula editável encontrada nessa direção.');
}

// Função para dar foco e mover o cursor para o fim
function focusCell($cell) {
    $cell.focus();
    let range = document.createRange();
    let sel = window.getSelection();
    range.selectNodeContents($cell[0]);
    range.collapse(false);
    sel.removeAllRanges();
    sel.addRange(range);


}




// funcao que guarda nodatatable



function  guardarNodatatable($cell){
    const linha = parseInt($cell.attr("linha"));
    const coluna = $cell.attr('coluna');


        // Inicializar linha no array caso não exista
        if (!$dadosparaEnvio[linha]) {
            $dadosparaEnvio[linha] = [];
        }

        // Pegar valor da célula e limpar espaços
        let valor = $cell.text().trim();

        // Validar valor (0 a 20, permite decimal)
        const regex = /^(([0-9](\.[0-9]{1,2})?)|(1[0-9](\.[0-9]{1,2})?)|20)$/;
        if (!regex.test(valor)) {
            valor = ""; // valor inválido
            $cell.text(""); // limpa célula
        }

        // Atualizar array de envio
        $dadosparaEnvio[linha][coluna] = valor;

        // Atualizar DataTable de forma segura
        if ($tabelatrimestral && $tabelatrimestral.row(linha).length) {
            $tabelatrimestral.row(linha).data($dadosparaEnvio[linha]).draw(false);
        }
}

// media por disciplina
function mediapordisciplina($celula) {



    // let formula = $celula.attr("formula");
    let formula =$('[name="formmulacriada"]').val();
    const disciplina = $celula.attr("disciplina");
    const linha = parseInt($celula.attr("linha"));

    // Substituir os identificadores da fórmula pelos valores reais
    $('td[linha="' + linha + '"][disciplina="' + disciplina + '"]').each(function () {
        const nt = $(this).attr('NT');
        console.log("nota nome",nt);
        let nota = parseFloat($(this).text().trim());



        // Se nota não for número válido, define como 0
        if (isNaN(nota)) {
            nota = 0;
        }

        // Substitui o identificador (ex: "NT1NF") pela nota
        formula = formula.replace(nt, nota);
        console.log(formula);


    });


    // Identifica a célula onde a média será exibida
    const mediacoluna = linha + "" + disciplina;
    const $celulaMedia = $("#" + mediacoluna + "");
    const colunaMedia = $celulaMedia.attr("coluna");

    // Avalia a fórmula e formata a média
    let media = 0;
    try {
        media = math.evaluate(formula);

        // Se der NaN ou valor inválido, força para 0
        if (isNaN(media) || media === null) {
            media = 0;
        }
    } catch (error) {
        console.error("Erro ao avaliar fórmula:", formula, error);
        media = 0;
    }
      // console.log(media);


    let mediaPrecisao = 0;
    try {
        mediaPrecisao = math.format(media, 3);
    } catch {
        mediaPrecisao = 0;
    }


      const fator = Math.pow(10, 0);
  $valorgravar= Math.round(mediaPrecisao * fator) / fator;
  mediaPrecisao=$valorgravar;

    // Atualizar array de envio de forma segura
    if (!$dadosparaEnvio[linha]) {
        $dadosparaEnvio[linha] = [];
    }
    if(mediaPrecisao>=0 &&mediaPrecisao<=20){
    $dadosparaEnvio[linha][colunaMedia] = mediaPrecisao;
    }

    // Atualizar DataTable sem perder a página
    // console.log(colunaMedia,mediacoluna);

    if ($tabelatrimestral && $tabelatrimestral.row(linha).length) {
        $tabelatrimestral.row(linha).data($dadosparaEnvio[linha]).draw(false);

        // Restaurar foco na célula de média (opcional)
       // $celulaMedia.focus();
    }
}



    function exportarParaExcel() {
        mostrarStatus('Preparando download do Excel...', 'info');

        // Criar uma cópia da tabela sem elementos de UI do DataTables
        let table = document.getElementById('listadosalunos');
        let clone = table.cloneNode(true);

        // Remover elementos do DataTables
        $(clone).find('.sorting, .sorting_asc, .sorting_desc').removeClass('sorting sorting_asc sorting_desc');

        // Criar HTML para exportação
        let html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Notas dos Alunos</title></head><body>';
        html += clone.outerHTML;
        html += '</body></html>';

        // Criar blob e link de download
        let blob = new Blob([html], {type: 'application/vnd.ms-excel'});
        let url = URL.createObjectURL(blob);
        let a = document.createElement('a');
        a.href = url;
        a.download = 'notas_alunos_turma.xls';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);

        mostrarStatus('Download iniciado!', 'success');
    }


   function mostrarStatus(mensagem, tipo) {
        const statusBar = $('#statusBar');
        const statusText = $('#statusText');

        statusText.text(mensagem);
        statusBar.removeClass('d-none alert-info alert-success alert-danger')
                .addClass('alert-' + (tipo === 'error' ? 'danger' : tipo));

        // Auto-esconder após 5 segundos para mensagens de sucesso
        if (tipo === 'success') {
            setTimeout(() => {
                statusBar.addClass('d-none');
            }, 5000);
        }
    }


    // botao de pesquisa

      // Associar o evento de digitação no input de pesquisa ao DataTable
            $(document).on('keyup','#searchFarmacos', function() {

                $tabelatrimestral.search(this.value).draw();
            });


function organisarArraySava($linha) {
    const dados = {};

    if (!Array.isArray(classe_disciplinas)) {
        console.warn("classe_disciplinas não é um array válido.");
        return dados;
    }

    classe_disciplinas.forEach(({ disciplina }) => {
        const disciplinaId = disciplina?.id;
        if (!disciplinaId) return;

        const disciplinaDados = {};

        $linha.find(`td[disciplina="${disciplinaId}"]`).each(function () {
            const chaveRaw = $(this).attr('NT');
            const chave = isNaN(parseInt(chaveRaw)) ? 100 : parseInt(chaveRaw);
            const valor = $(this).text().trim();

            disciplinaDados[chave] = valor;
        });

        dados[disciplinaId] = disciplinaDados;
    });

    // console.log("dados disciplina", dados);
    return dados;
}

 // calculara media de cada disciplina

function mediapordisciplinatodas() {

    classe_disciplinas.forEach(function(disciplina) {
        // console.log("Disciplina:", disciplina.disciplina_id);

        let divisao = "";
        trimestre.forEach(function(t) {
            if (t.divisao == 1) divisao = t.divisao;
        });

        let totalLinhas = $dadosparaEnvio.length;

        for (let x = 0; x < totalLinhas; x++) {
            let seletor = "table td[title='" + divisao + "NFDisp" + disciplina.disciplina_id + "linha" + x + "']";
            let celula = $(seletor);

            if (celula.length) {
                // aplica média da disciplina
                mediapordisciplina(celula);

                // penúltima célula da mesma linha
                let celulaIteraada= celula.closest('tr');
               celulaPenultima=celulaIteraada.children('td').eq(-2);
                //  const formula = $("[name='formmulacriadaParamedia']").val();
//   $("[name='formulaanual']").val(formulaanual);

                if (celulaPenultima.attr("formulamediafinal")) {
    mediaAnual(celulaPenultima);
}

                precistirBD(celulaIteraada);


            } else {
                console.warn("Célula não encontrada:", seletor);
            }
        }
    });

}

//guardar cada linha
function guardaLinhaBD($aluno, $dados) {
    let $celula = $("table tr[dadosnota='" + $aluno + "']").find('td').eq(0);


    // console.log("Trimestre",trimestre);


    // Aplica spinner antes do envio
    $.ajax({
        url:urlmedia,
        type: "POST",
        dataType: "json",
        data: {
    id: $aluno,
    dados: $dados,
    disciplinas:classe_disciplinas,
    trimestres:trimestre,
    _token: _token
},
        beforeSend: function() {
            $celula
                .removeClass('sucesso') // remove ícone anterior, se houver
                .addClass('spiner')     // aplica spinner
                .html('<i class="fa fa-spinner fa-spin"></i>'); // ícone de carregamento
        },
        success: function(response) {
            // Substitui spinner por ícone de sucesso


            $celula
                .removeClass('spiner')
                .addClass('sucesso')
                .html('<i class="fa fa-check-circle text-success"></i>');

            // Remove ícone após 2 segundos
            setTimeout(function() {
                $celula.removeClass('sucesso').html('');
            }, 2000);
            $celula.text( $celula.attr('id'));





        },
        error: function(xhr, status, error) {
            console.error("Erro ao guardar dados:", error);
            $celula
                .removeClass('spiner')
                .addClass('erro')
                .html('<i class="fa fa-times-circle text-danger"></i>');
                 $celula.text( $celula.attr('id'));
        }
    });
}






function mediaAnual($celula) {
  const $linha = $celula.closest('tr');
  const linhanumero = parseInt($celula.attr("linha"));
  const $penultimaCelula = $linha.children('td').eq(-2);
  const colunaMedia = $penultimaCelula.index();
  let formulaInfo = $penultimaCelula.attr('formulamediafinal');

  if (!formulaInfo) return;

  // Substitui siglas pelas notas
  $linha.find('td[siglaDisp]').each(function () {
    const sigla = $(this).attr("siglaDisp");
    const texto = $(this).text().trim();
    const regex = new RegExp(`\\b${sigla}\\b`, 'g');
    formulaInfo = formulaInfo.replace(regex, texto);

  });

  // Avalia a fórmula
  let media = 0;
  try {
    media = math.evaluate(formulaInfo);
    if (isNaN(media) || media === null) media = 0;
  } catch (error) {
    console.error("Erro ao avaliar fórmula:", formulaInfo, error);
    media = 0;
  }

  // Formata e arredonda
  let mediaPrecisao = 0;
  try {
    mediaPrecisao = parseFloat(math.format(media, { precision: 3 }));
  } catch {
    mediaPrecisao = 0;
  }
  mediaPrecisao = Math.round(mediaPrecisao);

  // Atualiza array de envio
  if (!$dadosparaEnvio[linhanumero]) {
    $dadosparaEnvio[linhanumero] = [];
  }
  if (mediaPrecisao >= 0 && mediaPrecisao <= 20) {
    $dadosparaEnvio[linhanumero][colunaMedia] = mediaPrecisao;
  }

  // Atualiza visualmente a célula
  $penultimaCelula.text(mediaPrecisao);

  // Atualiza na DataTable
  if ($tabelatrimestral && $tabelatrimestral.row(linhanumero).length) {
    $tabelatrimestral.row(linhanumero).data($dadosparaEnvio[linhanumero]).draw(false);
  }

  // Logs úteis
//   console.log("📐 Fórmula resolvida:", formulaInfo);
//  console.log("🎓 Média calculada:", mediaPrecisao);
}




// Alternar ícone de cadeado
$(document).on("click", '.toggle-lock', function () {
    if ($(this).hasClass('fa-unlock')) {
        // De desbloqueado para bloqueado
        $(this).removeClass('fa-unlock text-success').addClass('fa-lock text-danger');
    } else {
        // De bloqueado para desbloqueado
        $(this).removeClass('fa-lock text-danger').addClass('fa-unlock text-success');
    }
});




$(document).on('click', '#btnTrancarSelecionados', function () {

    const trimestre=($(this).attr("valor"));

    const dadosid=[];
   window.$idalunos.forEach(function(e){
    dadosid.push(e.id);

   })
// console.log(dadosid);

    $trimestreTrancado=[];
$('.trimestre-item').each(function () {
    const $icon = $(this).find('i.fa-lock');
    if ($icon.length > 0) {
        const valor = $(this).data('trimestre-id');
        // console.log('Trimestre ID com ícone de cadeado:', valor);
         $trimestreTrancado.push(valor);
    }
});

    $.ajax({
        url:urlTrancar,
        type:"POST",
        dataType:"json",
        data:{
trimestre: $trimestreTrancado,
alunos:dadosid,
turma:turma,
_token:_token
        },
        success:function(e){
// console.log(e);
        }
    })


});


$(document).on('click', '.GereraResultado', function () {

    const $botao = $(this);
    const estadoAtual = $botao.attr('data-estado');

    if (estadoAtual === 'on') {
        // Desativar
        $botao
            .attr('data-estado', 'off')
            .removeClass('bg-success')
            .addClass('bg-secondary')
            .text('❌ Desativado');
    } else {
        // Ativar
        $botao
            .attr('data-estado', 'on')
            .removeClass('bg-secondary')
            .addClass('bg-success')
            .text('✅ Resultado');

        // Percorrer todas as linhas da tabela
        $('table tbody tr').each(function () {
            const $linha = $(this);
            const $celulaColuna4 = $linha.find('td').eq(3); // coluna 4 (índice 3)
            Resultado($celulaColuna4);
        });
    }
});











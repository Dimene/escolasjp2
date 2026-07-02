$(document).ready(function () {
    const tabela = $("#listadosalunos").DataTable({
        responsive: true,
        fixedColumns: true,
        paging: false,
        searching: false,
        info: false
    });

    // Botão Excel
    $(document).on("click", ".BaixarExcel", function () {
        $.ajax({
            url: urlImprimir,
            type: "POST",
            data: {
                "_token": $("[name='_token']").val(),
                "dados": tabela.rows().data().toArray(),
                "Disciplina": disciplinasClasse,
                "trimestres": trimestres
            },
            xhrFields: { responseType: "blob" },
            success: function (response) {
                const url = window.URL.createObjectURL(response);
                const a = document.createElement("a");
                a.href = url;
                a.download = "pauta.xlsx";
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire("Erro", "Não foi possível gerar o Excel", "error");
            }
        });
    });

    // Botão Gerar Resultado
    $(document).on("click", ".GereraResultado", function () {
        const dados = tabela.rows().data().toArray();
        const novosDados = gerarResultado(dados, disciplinasClasse, trimestres);

        novosDados.forEach((linha, i) => {
            tabela.row(i).data(linha).draw();
            const rowNode = $(tabela.row(i).node());
            if (linha[linha.length - 1].includes("Aprovad")) {
                rowNode.removeClass("table-danger").addClass("table-success");
            } else {
                rowNode.removeClass("table-success").addClass("table-danger");
            }
        });

        Swal.fire("Sucesso", "Resultados atualizados!", "success");
    });
});

// Função principal para calcular resultado
function gerarResultado(dados, disciplinas, trimestres) {
    let dadosRetorno = [];

    let dadosProcessados = dados.map(row => {
        let aluno = {
            id: row[0],
            Nome: row[1],
            sexo: row[2]
        };
        let y = 2;
        disciplinas.forEach(d => {
            for (let t = 0; t < (trimestres.length + 1); t++) {
                y++;
                if (t === trimestres.length) {
                    aluno[d.sigla] = parseFloat(row[y]) || 0;
                }
            }
        });
        return aluno;
    });

    let resultados = Resultado2(disciplinas, dadosProcessados);

    dados.forEach((row, i) => {
        row[row.length - 1] = resultados[i].Resultado;
        dadosRetorno.push(row);
    });

    return dadosRetorno;
}

// Regras de aprovação/reprovação
function Resultado2(disciplinas, dados) {
    dados.forEach(item => {
        let result = "Aprovad";
        let negativasOutras = 0;

        for (let disp of disciplinas) {
            let nota = parseFloat(item[disp.sigla]) || 0;

            if (disp.sigla === "P" || disp.sigla === "M") {
                if (nota < 10) {
                    result = "Reprovad";
                    break;
                }
            } else if (nota < 7) {
                negativasOutras++;
                if (negativasOutras > 2) {
                    result = "Reprovad";
                    break;
                }
            }
        }

        result += (item.sexo === "F") ? "a" : "o";
        item.Resultado = result;
    });
    return dados;
}

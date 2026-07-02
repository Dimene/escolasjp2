
function loadDados() {
    const ano    = $("[name='anolectivo_id']").val();
    const tipo   = $("[name='lista-tipopagamento']").val();
    const classe = $("[name='classe_id']").val();
    const mesId  = $("select[name='mes_id']").val();

    const dados = @json($dados);

    // Garantir que a comparação funcione mesmo se for número ou string
    let filtrados = dados.filter(d => {
        return (!ano    || String(d.anolectivo_id) === String(ano)) &&
               (!classe || String(d.classe_id ?? '') === String(classe)) &&
               (!tipo   || String(d.id) === String(tipo));
    });

    // Extrai arrays únicos de campos
    const classesArr = [...new Set(filtrados.map(d => d.classe_id))];
    const mesesArr   = [...new Set(filtrados.map(d => d.mes))];
    const anosArr    = [...new Set(filtrados.map(d => d.ano))];
    const anoLectivosArr = [...new Set(filtrados.map(d => d.anolectivo_id))];

    console.log("Filtrados:", filtrados);
    console.log("Classes:", classesArr);
    console.log("Meses:", mesesArr);
    console.log("Anos:", anosArr);
    console.log("AnoLectivos:", anoLectivosArr);
    console.log("todos:", dados);
}


    // Função para carregar a tabela
    function loadTabela() {
        const ano    = $("[name='anolectivo_id']").val();
        const tipo   = $(".dadotipo").val();
        const classe = $("[name='classe_id']").val();
        const mes    = $("[name='mes_id']").val();
        const flag   = $(".flagdetipo").val();

        $(".add-table").html('<div class="text-center p-4"><img src="{{ asset('imageproceaament/loading.gif') }}" width="120"></div>');

        $.get(`/RegistoAcademico/outrosPagamento/show/${ano}/${classe}/${tipo}/${mes}/${flag}`, function (html) {
            $(".add-table").html(html);
        });
    };

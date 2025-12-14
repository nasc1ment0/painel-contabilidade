//TABELA PADRÃO
$('#tablePadrao').DataTable({
    "language": {
        "url": "js/pt-BR.json"
    },
    "pageLength": 10,
    "ordering": true,
    "searching": true,
    "info": true
});

//TABELA DE DOWNLOADS
function carregarTabelaDownload(idCliente) {
    $("#cardDownload").show();

    if ($.fn.DataTable.isDataTable("#tabelaDownload")) {
        $("#tabelaDownload").DataTable().clear().destroy();
    }

    tabelaDownload = $("#tabelaDownload").DataTable({
        language: { url: "js/pt-BR.json" },
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "funcoes/buscas/datatable_download.php?id_cliente=" + idCliente,
            type: "POST"
        },
        pageLength: 10,
        columns: [
            { data: "id_upload" },
            { data: "arquivo" },
            { data: "data" },
            { data: "acoes" }
        ]
    });
}



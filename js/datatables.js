// Inicializar DataTable (quando incluir a biblioteca)
document.addEventListener('DOMContentLoaded', function() {
    if(typeof $.fn.DataTable !== 'undefined') {
        $('#tabelaAcessos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
            },
            "pageLength": 10,
            "ordering": true,
            "searching": true,
            "info": true
        });
    }
});
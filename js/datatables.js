// Inicializar DataTable (quando incluir a biblioteca)
document.addEventListener('DOMContentLoaded', function() {
    if(typeof $.fn.DataTable !== 'undefined') {
        $('#tablePadrao').DataTable({
            "language": {
                "url": "js/pt-BR.json"
            },
            "pageLength": 10,
            "ordering": true,
            "searching": true,
            "info": true
        });
    }
});
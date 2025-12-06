<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Upload de Arquivos</h5>
    </div>
    <div class="card-body">
        <!-- Exibe mensagens -->
        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo_mensagem'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['mensagem']; ?>
            </div>
            <?php
            unset($_SESSION['mensagem']);
            unset($_SESSION['tipo_mensagem']);
        endif; ?>

        <form id="formUpload" method="POST" action="index.php?rotina=5&mod=1" enctype="multipart/form-data">

            <!-- Seleção do Cliente -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="cliente" class="form-label">Cliente <span class="text-danger">*</span></label>
                    <input type="text" id="nm_cliente" placeholder="Digite para buscar clientes..."
                        class="form-control input-sm">
                    <input type="hidden" id="id_cliente" name="id_cliente">
                </div>
            </div>

            <!-- Upload de Arquivos -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="arquivos" class="form-label">Arquivos <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="arquivos" name="arquivos[]" multiple >
                </div>
            </div>

            <!-- Botão Upload -->
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100" id="btn-upload">
                        <i class="fas fa-upload"></i> Enviar para o Cliente
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
$(document).ready(function () {

    $("#nm_cliente").autocomplete({
        source: "funcoes/buscas/buscaCliente.php",
        minLength: 2,
        select: function (event, ui) {
            $("#id_cliente").val(ui.item.id_cliente);
        }
    });

    // VALIDAÇÃO ANTES DO SUBMIT
    $("#formUpload").on("submit", function (e) {
        let idCliente = $("#id_cliente").val().trim();
        let arquivos  = $("#arquivos")[0].files.length;
        let erros = [];

        if (!idCliente) {
            erros.push("Selecione um cliente válido.");
        }

        if (arquivos === 0) {
            erros.push("Selecione pelo menos um arquivo para upload.");
        }

        if (erros.length > 0) {
            e.preventDefault(); // Bloqueia o envio do form

            // Remove alert anterior se existir
            $("#alert-validation").remove();

            // Cria novo alerta
            let alertaHTML = `
            <div id="alert-validation" class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Ops! Verifique os campos:</strong>
                <ul class="mb-0 mt-2">
                    ${erros.map(err => `<li>${err}</li>`).join("")}
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;

            $(".card-body").prepend(alertaHTML);
        }
    });

});
</script>
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

<!-- MODAL DE CARREGAMENTO -->
<div class="modal fade" id="modalCarregando" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content d-flex flex-column justify-content-center align-items-center p-4 text-center">

      <div class="spinner-border text-primary mb-3" style="width: 4rem; height: 4rem;" role="status"></div>

      <h5>Aguarde...</h5>
      <p>Enviando arquivos e notificando o cliente.</p>

    </div>
  </div>
</div>


<!-- MODAL DE SUCESSO -->
<div class="modal fade" id="modalSucesso" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 text-center">

      <div class="text-success" style="font-size: 4rem;">✔</div>

      <h4 class="mt-3">Tudo certo!</h4>
      <p>Seus arquivos foram enviados com sucesso.</p>

      <button class="btn btn-success mt-2" data-bs-dismiss="modal">OK</button>

    </div>
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

    if (!idCliente) erros.push("Selecione um cliente válido.");
    if (arquivos === 0) erros.push("Selecione pelo menos um arquivo.");

    if (erros.length > 0) {
        e.preventDefault();

        $("#alert-validation").remove();

        let alertaHTML = `
        <div id="alert-validation" class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong>Ops! Verifique os campos:</strong>
            <ul class="mb-0 mt-2">
                ${erros.map(err => `<li>${err}</li>`).join("")}
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;

        $(".card-body").prepend(alertaHTML);

    } else {
        e.preventDefault(); // NÃO deixar enviar ainda!

        // Abre modal de carregamento
        let modalLoad = new bootstrap.Modal(document.getElementById('modalCarregando'));
        modalLoad.show();

        // Envia form manualmente depois de 300ms
        setTimeout(() => {
            $("#formUpload")[0].submit();
        }, 300);
    }
});

});
</script>

<?php if (isset($_SESSION['mensagem']) && $_SESSION['tipo_mensagem'] == 'success'): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(() => {
        let modalOk = new bootstrap.Modal(document.getElementById('modalSucesso'));
        modalOk.show();
    }, 100);
});
</script>
<?php 
unset($_SESSION['mensagem']);
unset($_SESSION['tipo_mensagem']);
endif; ?>


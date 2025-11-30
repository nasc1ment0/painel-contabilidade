<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Upload de Arquivos</h5>
        <a href="index.php?rotina=4&mod=0" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    <div class="card-body">
        <form id="formUpload" method="POST" action="processar_upload.php" enctype="multipart/form-data">

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
                    <input type="file" class="form-control" id="arquivos" name="arquivos[]" multiple required>
                </div>
            </div>

            <!-- Botão Upload -->
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100" id="btn-upload" disabled>
                        <i class="fas fa-upload"></i> Fazer Upload
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("#nm_cliente").autocomplete({
            source: "funcoes/buscas/buscacliente.php",
            minLength: 2,
            select: function (event, ui) {
                $("#id_cliente").val(ui.item.id_cliente);
            }
        });
    });
</script>
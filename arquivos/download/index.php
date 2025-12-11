<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Visualização de Arquivos</h5>
    </div>
    <div class="card-body">
        <!-- Seleção do Cliente -->
        <div class="row mb-4">
            <div class="col-md-12">
                <label for="cliente" class="form-label">Cliente <span class="text-danger">*</span></label>
                <input type="text" id="nm_cliente" placeholder="Digite para buscar clientes..."
                    class="form-control input-sm">
                <input type="hidden" id="id_cliente" name="id_cliente">
            </div>
        </div>

        <div class="card mt-4" id="cardDownload" style="display:none;">
            <div class="card-header">
                <h5 class="card-title mb-0">Arquivos do Cliente</h5>
            </div>
            <div class="card-body">
                <table id="tabelaDownload" class="table table-striped table-hover" width="100%">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th width="50%">Arquivo</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        let tabelaDownload = null;
        $("#nm_cliente").autocomplete({
            source: "funcoes/buscas/buscaCliente.php",
            minLength: 2,
            select: function (event, ui) {
                $("#id_cliente").val(ui.item.id_cliente);
                carregarTabelaDownload(ui.item.id_cliente);
            }
        });
    });

</script>
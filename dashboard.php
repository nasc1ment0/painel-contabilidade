<div class="row">
    <!-- Gráfico de Linha - Uploads Mensais -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Uploads Mensais
            </div>
            <div class="card-body">
                <canvas id="uploadsChart" height="100%"></canvas>
            </div>
        </div>
    </div>

    <!-- Gráfico de Pizza - Tipos de Arquivo -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i> Tipos de Arquivo Mais Usados
            </div>
            <div class="card-body">
                <canvas id="fileTypesChart" height="100%"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Gráfico de Barras - Atividades por Usuário -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-column"></i> Atividades por Usuário
            </div>
            <div class="card-body">
                <canvas id="userActivityChart" height="100%"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <span>
                    <i class="fas fa-chart-simple"></i> Tipos de Mensagens Mais Enviadas
                </span>
                <div class="ms-auto">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="btnDetalhesMensagens">
                        <i class="fas fa-info"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <canvas id="tpMensagensChart" height="100%"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMensagens" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-envelope"></i> Mensagens Enviadas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table id="tabelaMensagens" class="table table-striped table-hover w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Tipo</th>
                            <th>Mensagem</th>
                            <th>Cliente</th>
                            <th>Usuário</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        //Gráfico de uploads
        fetch("funcoes/buscas/dados_upload.php")
            .then(res => res.json())
            .then(data => {
                new Chart(document.getElementById('uploadsChart'), {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Uploads',
                            data: data.values,
                            borderColor: '#094d6e',
                            backgroundColor: 'rgba(52, 152, 219, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    }
                });
            });

        // Gráfico de Tipos de Arquivo
        fetch("funcoes/buscas/dados_tparquivo.php")
            .then(res => res.json())
            .then(data => {
                new Chart(document.getElementById('fileTypesChart'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Quantidade',
                            data: data.values,
                            backgroundColor: ['#094d6e', '#80C9AE', '#E0B079', '#595959', '#0F2433']
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Isso faz as barras ficarem horizontais
                    }
                });
            });

        // Gráfico de Atividades por Usuário
        fetch("funcoes/buscas/dados_usuario.php")
            .then(res => res.json())
            .then(data => {
                new Chart(document.getElementById('userActivityChart'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Uploads por Usuário',
                            data: data.values,
                            backgroundColor: ['#094d6e', '#80C9AE', '#E0B079', '#595959', '#0F2433']
                        }]
                    }
                });
            });

        //Gráfico de tipos de mensagem
        fetch("funcoes/buscas/dados_tp_mensagem.php")
            .then(res => res.json())
            .then(data => {
                new Chart(document.getElementById('tpMensagensChart'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Tipos de Mensagem',
                            data: data.values,
                            backgroundColor: ['#094d6e', '#80C9AE', '#E0B079', '#595959', '#0F2433'],
                            tension: 0.4,
                            fill: true
                        }]
                    }
                });
            });
    });

    //TABELA DE MENSAGENS
    $(document).ready(function () {
        let tabelaMensagens = null;

        $("#btnDetalhesMensagens").on("click", function () {
            $("#modalMensagens").modal("show");

            if (!$.fn.DataTable.isDataTable('#tabelaMensagens')) {
                tabelaMensagens = $('#tabelaMensagens').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[4, 'desc']],
                    pageLength: 10,
                    ajax: {
                        url: "funcoes/buscas/datatable_mensagens.php",
                        type: "POST"
                    },
                    columns: [
                        { data: "tipo_mensagem", title: "Tipo de Mensagem" },
                        { data: "texto", title: "Texto" },
                        { data: "cliente", title: "Cliente" },
                        { data: "usuario", title: "Usuário" },
                        { data: "data_envio", title: "Data de Envio" }
                    ],
                    language: { url: "js/pt-BR.json" }
                });
            }
        });
    });

</script>
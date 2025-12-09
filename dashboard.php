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
                <i class="fas fa-chart-bar"></i> Atividades por Usuário
            </div>
            <div class="card-body">
                <canvas id="userActivityChart" height="100%"></canvas>
            </div>
        </div>
    </div>

    <!-- Gráfico de de rosquinha - Comparação de tipos de cliente -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-area"></i> Comparação de Tipos de Clientes (%)
            </div>
            <div class="card-body">
                <canvas id="comparisonChart" height="160"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="js/chart.js"></script>

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
                            borderColor: '#3498db',
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
                            backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6']
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
                            backgroundColor: '#3498db'
                        }]
                    }
                });
            });

        // Gráfico de Comparação de tipos de cliente
        fetch("funcoes/buscas/dados_clientes.php")
        .then(res => res.json())
            .then(data => {
        new Chart(document.getElementById('comparisonChart'), {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                        label: 'Tipo de Cliente',
                        data: data.values,
                        backgroundColor: ['#3498db', '#9b59b6'],
                        fill: true
                    }]
            },
            options: {
                maintainAspectRatio: false
            }
        });
    });
    });
</script>
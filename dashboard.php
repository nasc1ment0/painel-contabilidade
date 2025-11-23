<div class="row">
    <!-- Gráfico de Linha - Uploads Mensais -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Uploads Mensais
            </div>
            <div class="card-body">
                <canvas id="uploadsChart" height="120"></canvas>
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
                <canvas id="fileTypesChart" height="120"></canvas>
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
                <canvas id="userActivityChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <!-- Gráfico de Área - Uploads vs Downloads -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-area"></i> Uploads vs Downloads
            </div>
            <div class="card-body">
                <canvas id="comparisonChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="js/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gráfico de Downloads Mensais
        new Chart(document.getElementById('uploadsChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Uploads',
                    data: [65, 59, 80, 81, 56, 55],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            }
        });

        // Gráfico de Tipos de Arquivo
        new Chart(document.getElementById('fileTypesChart'), {
            type: 'bar',
            data: {
                labels: ['PDF', 'Imagens', 'Documentos', 'Planilhas', 'Apresentações'],
                datasets: [{
                    label: 'Quantidade',
                    data: [45, 30, 25, 15, 10],
                    backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6']
                }]
            },
            options: {
                indexAxis: 'y', // Isso faz as barras ficarem horizontais
            }
        });

        // Gráfico de Atividades por Usuário
        new Chart(document.getElementById('userActivityChart'), {
            type: 'bar',
            data: {
                labels: ['Admin', 'João', 'Maria', 'Pedro', 'Ana'],
                datasets: [{
                    label: 'Atividades',
                    data: [45, 30, 25, 20, 15],
                    backgroundColor: '#2ecc71'
                }]
            }
        });

        // Gráfico de Comparação Uploads vs Downloads
        new Chart(document.getElementById('comparisonChart'), {
            type: 'line',
            data: {
                labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex'],
                datasets: [
                    {
                        label: 'Uploads',
                        data: [12, 19, 8, 15, 10],
                        borderColor: '#e74c3c',
                        backgroundColor: 'rgba(231, 76, 60, 0.1)',
                        fill: true
                    },
                    {
                        label: 'Downloads',
                        data: [25, 30, 22, 28, 35],
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        fill: true
                    }
                ]
            }
        });
    });
</script>
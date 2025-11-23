<?php
session_start();

require "classes/classe_conexao.php";
$db = new Database();

if (!isset($_SESSION['usuario'])) {
    exit("<script>alert('Faça login no sistema!'); location='login.php'</script>");
}

$usuario = $_SESSION['usuario']['nm_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Sistema</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h6 class="text-center text-light mb-0">
                <img src="imagens/logo-empresa.png" alt="" class="logo">
                <p style="margin-top:10px">Bem vindo, <?php echo $usuario ?>!</p>
            </h6>
        </div>

        <a href="#" class="menu-item">
            <i class="fas fa-chart-line"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="#" class="menu-item has-submenu" id="cadastros-menu">
            <i class="fas fa-user-plus"></i>
            <span class="menu-text">Cadastros</span>
        </a>
        <div class="submenu" id="cadastros-submenu">
            <a href="#"><i class="fas fa-key"></i> Tipos de acesso</a>
            <a href="#"><i class="fas fa-users"></i> Usuários</a>
            <a href="#"><i class="fas fa-user-tie"></i> Clientes</a>
        </div>

        <a href="#" class="menu-item has-submenu" id="arquivos-menu">
            <i class="fas fa-folder-open"></i>
            <span class="menu-text">Arquivos</span>
        </a>
        <div class="submenu" id="arquivos-submenu">
            <a href="#"><i class="fas fa-download"></i> Download</a>
            <a href="#"><i class="fas fa-upload"></i> Upload</a>
        </div>

        <a href="#" class="menu-item has-submenu" id="ajuda-menu">
            <i class="fas fa-question-circle"></i>
            <span class="menu-text">Ajuda</span>
        </a>
        <div class="submenu" id="ajuda-submenu">
            <a href="#"><i class="fas fa-info-circle"></i> Informações de funcionamento</a>
            <a href="#"><i class="fas fa-phone"></i> Contatos</a>
        </div>

        <div class="sidebar-footer" style="padding: 15px 20px; margin-top: auto;">
            <a href="logout.php" class="btn btn-outline-light btn-sm w-100">
                <i class="fas fa-sign-out-alt"></i> Sair
            </a>
        </div>
    </div>

    <div class="content">
        <h3 class="page-title">Painel Inicial</h3>

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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Adicionar evento de clique para os itens de menu com submenu
            const menuItems = document.querySelectorAll('.has-submenu');

            menuItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Fechar outros submenus abertos
                    menuItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('active')) {
                            otherItem.classList.remove('active');
                            const otherSubmenu = document.getElementById(otherItem.id.replace('-menu', '-submenu'));
                            otherSubmenu.classList.remove('show');
                        }
                    });

                    // Alternar o submenu atual
                    this.classList.toggle('active');
                    const submenuId = this.id.replace('-menu', '-submenu');
                    const submenu = document.getElementById(submenuId);
                    submenu.classList.toggle('show');
                });
            });

            // Fechar submenus ao clicar fora (em telas maiores)
            document.addEventListener('click', function (e) {
                if (window.innerWidth > 768) {
                    if (!e.target.closest('.sidebar')) {
                        menuItems.forEach(item => {
                            item.classList.remove('active');
                            const submenuId = item.id.replace('-menu', '-submenu');
                            const submenu = document.getElementById(submenuId);
                            submenu.classList.remove('show');
                        });
                    }
                }
            });

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
</body>

</html>
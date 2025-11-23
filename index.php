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

    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(to bottom, #2c3e50, #34495e);
            padding-top: 20px;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 10px;
        }

        .sidebar a {
            color: #ecf0f1;
            font-size: 15px;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar .menu-item {
            position: relative;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-footer .btn {
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .sidebar-footer .btn:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-1px);
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .submenu.show {
            max-height: 300px;
        }

        .submenu a {
            padding-left: 50px;
            font-size: 14px;
            background-color: transparent;
        }

        .submenu a:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .topbar {
            background: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-title {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }

        .logo {
            width: 150px;
            margin: 0 auto;
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }

            .sidebar .menu-text,
            .sidebar-header h4 {
                display: none;
            }

            .sidebar .menu-item.has-submenu::after {
                display: none;
            }

            .sidebar a i {
                margin-right: 0;
                font-size: 18px;
            }

            .content {
                margin-left: 70px;
            }

            .submenu a {
                padding-left: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h6 class="text-center text-light mb-0">
                <img src="imagens/logo-empresa.png" alt="" class="logo">
                <p style="margin-top:10px">Bem vindo, <?php echo$usuario?>!</p>
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar"></i> Estatísticas Rápidas
                    </div>
                    <div class="card-body">
                        <p>Conteúdo do painel vai aqui...</p>
                        <ul>
                            <li>Usuários cadastrados: 15</li>
                            <li>Arquivos disponíveis: 42</li>
                            <li>Downloads realizados: 128</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-clock"></i> Atividades Recentes
                    </div>
                    <div class="card-body">
                        <p>Últimas atividades do sistema...</p>
                        <ul>
                            <li>Novo usuário cadastrado - 2 horas atrás</li>
                            <li>Arquivo enviado - 5 horas atrás</li>
                            <li>Download realizado - 1 dia atrás</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        });
    </script>
</body>

</html>
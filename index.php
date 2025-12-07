<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
ob_start();
require "classes/classe_conexao.php";
$db = new Database();
require "funcoes/funcoes.php";

if (!isset($_SESSION['usuario'])) {
    exit("<script>alert('Faça login no sistema!'); location='login.php'</script>");
}

$usuario = $_SESSION['usuario']['nm_usuario'];
$id_usuario = $_SESSION['usuario']['id'];

// Sistema de rotas
$rotina = isset($_GET['rotina']) ? (int) $_GET['rotina'] : 0;
$mod = isset($_GET['mod']) ? (int) $_GET['mod'] : 0;

// Definir título da página baseado na rotina
$titulos = [
    0 => 'Painel Inicial',
    1 => 'Tipos de Acesso',
    2 => 'Usuários',
    3 => 'Clientes',
    4 => 'Download de Arquivos',
    5 => 'Envio de Arquivos',
    6 => 'Informações do Sistema',
    7 => 'Contatos'
];

$page_title = isset($titulos[$rotina]) ? $titulos[$rotina] : 'Painel Inicial';
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
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <script src="js/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h6 class="text-center text-light mb-0">
                <img src="imagens/logo-empresa.png" alt="" class="logo">
                <p style="margin-top:10px">Bem vindo, <?php echo $usuario ?>!</p>
            </h6>
        </div>

        <a href="index.php" class="menu-item">
            <i class="fas fa-chart-line"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="#" class="menu-item has-submenu" id="cadastros-menu">
            <i class="fas fa-user-plus"></i>
            <span class="menu-text">Cadastros</span>
        </a>
        <div class="submenu" id="cadastros-submenu">
            <a href="index.php?rotina=1&mod=0"><i class="fas fa-key"></i> Tipos de acesso</a>
            <a href="index.php?rotina=2&mod=0"><i class="fas fa-users"></i> Usuários</a>
            <a href="index.php?rotina=3&mod=0"><i class="fas fa-user-tie"></i> Clientes</a>
        </div>

        <a href="#" class="menu-item has-submenu" id="arquivos-menu">
            <i class="fas fa-folder-open"></i>
            <span class="menu-text">Arquivos</span>
        </a>
        <div class="submenu" id="arquivos-submenu">
            <a href="index.php?rotina=4&mod=0"><i class="fas fa-download"></i> Download</a>
            <a href="index.php?rotina=5&mod=0"><i class="fas fa-upload"></i> Upload</a>
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
        <h3 class="page-title"><?php echo $page_title; ?></h3>
        <?php
        // Sistema de carregamento de rotinas
        switch ($rotina) {
            case 0: // Dashboard
                include('dashboard.php');
            break;

            case 1: // Tipos de acesso
                if ($mod == 0) {
                    include('cadastros/acessos/index.php');
                } elseif ($mod == 1) {
                    include('cadastros/acessos/cadastro.php');
                }elseif ($mod == 2) {
                    include('cadastros/acessos/salvar.php');
                }elseif ($mod == 3) {
                    include('cadastros/acessos/inativa_cad.php');
                }
            break;

            case 2: // Usuários
                if ($mod == 0) {
                    include('cadastros/usuarios/index.php');
                }elseif ($mod == 1) {
                    include('cadastros/usuarios/cadastro.php');
                }elseif($mod == 2){
                    include('cadastros/usuarios/salvar.php');
                }elseif ($mod == 3) {
                    include('cadastros/usuarios/inativa_cad.php');
                }
                break;

            case 3: // Clientes
                if ($mod == 0) {
                    include('cadastros/clientes/index.php');
                }elseif ($mod == 1) {
                    include('cadastros/clientes/cadastro.php');
                }elseif ($mod == 2) {
                    include('cadastros/clientes/salvar.php');
                }elseif ($mod == 3) {
                    include('cadastros/clientes/inativa_cad.php');
                }
            break;

            case 4: // Download
                if ($mod == 0) {
                    include('rotinas/arquivos/download.php');
                }
                break;

            case 5: // Upload
                if ($mod == 0) {
                    include('arquivos/upload/index.php');
                }elseif($mod == 1) {
                    include('arquivos/upload/processa_arquivos.php');
                }
                break;

            case 6: // Informações
                if ($mod == 0) {
                    include('rotinas/ajuda/informacoes.php');
                }
                break;

            case 7: // Contatos
                if ($mod == 0) {
                    include('rotinas/ajuda/contatos.php');
                }
                break;

            default: // Dashboard padrão
                include('rotinas/dashboard.php');
                break;
        }
        ?>
    </div>

    <!-- Gráficos -->
    <script src="js/chart.js"></script>

    <!-- Datatable -->
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>

    <!-- Autocomplete UI -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-ui.js"></script>

    <!-- Mascáras JS -->
    <script src="js/masks.js"></script>

    <!-- Bootstrap modal -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Script pro submenu -->
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
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
    6 => 'Tipos de Mensagem',
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
    <link rel="icon" type="image/x-icon" href="imagens/icon-empresa.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Fonte do sistema -->
    <link href="css/fonts/font-montserrat.css" rel="stylesheet">

    <!-- Estilo sistema -->
    <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">

    <!-- Datatable -->
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="css/bootstrap-icons.css">

    <!-- SweetAlert modal -->
    <script src="js/sweetalert.js"></script>

    <!-- AdminLTE - Responsivo -->
    <link rel="stylesheet" href="css/adminlte.min.css">
    <link rel="stylesheet" href="css/all.min.css">


    <!-- Jquery -->
    <script src="js/jquery-3.6.0.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <!-- NAVBAR (topo) -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <span class="navbar-text ml-3">
                <?php echo $page_title; ?>
            </span>
        </nav>

        <!-- SIDEBAR -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!-- LOGO -->
            <a href="index.php" class="brand-link text-center brand-custom">
                <!-- Logo grande (menu aberto) -->
                <img src="imagens/logo-empresa.png" class="logo logo-lg">

                <!-- Logo pequeno (menu fechado) -->
                <img src="imagens/logo-empresa.png" class="logo2 logo-sm">

                <div class="brand-user">
                    Bem-vindo, <strong><?php echo $usuario; ?></strong>
                </div>
            </a>

            <!-- SIDEBAR MENU -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Cadastros
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?rotina=1&mod=0" class="nav-link">
                                        <i style="font-size:14px;" class="fas fa-key nav-icon"></i>
                                        <p style="font-size:14px;">Tipos de acesso</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?rotina=2&mod=0" class="nav-link">
                                        <i style="font-size:14px;" class="fas fa-users nav-icon"></i>
                                        <p style="font-size:14px;">Usuários</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?rotina=3&mod=0" class="nav-link">
                                        <i style="font-size:14px;" class="fas fa-user-tie nav-icon"></i>
                                        <p style="font-size:14px;">Clientes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p>
                                    Arquivos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?rotina=6&mod=0" class="nav-link">
                                        <i style="font-size:14px;" class="fas fa-envelope nav-icon"></i>
                                        <p style="font-size:14px;">Tipos de mensagem</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?rotina=4&mod=0" class="nav-link">
                                        <i style="font-size:14px;" class="fas fa-download nav-icon"></i>
                                        <p style="font-size:14px;">Download</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?rotina=5&mod=0" class="nav-link">
                                        <i style="font-size:14px;" class="fas fa-upload nav-icon"></i>
                                        <p style="font-size:14px;">Upload</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <hr style="background-color:gray">

                        <li class="nav-item">
                            <a href="logout.php" class="nav-link text-danger">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Sair</p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper p-4">
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
                    } elseif ($mod == 2) {
                        include('cadastros/acessos/salvar.php');
                    } elseif ($mod == 3) {
                        include('cadastros/acessos/inativa_cad.php');
                    }
                    break;

                case 2: // Usuários
                    if ($mod == 0) {
                        include('cadastros/usuarios/index.php');
                    } elseif ($mod == 1) {
                        include('cadastros/usuarios/cadastro.php');
                    } elseif ($mod == 2) {
                        include('cadastros/usuarios/salvar.php');
                    } elseif ($mod == 3) {
                        include('cadastros/usuarios/inativa_cad.php');
                    }
                    break;

                case 3: // Clientes
                    if ($mod == 0) {
                        include('cadastros/clientes/index.php');
                    } elseif ($mod == 1) {
                        include('cadastros/clientes/cadastro.php');
                    } elseif ($mod == 2) {
                        include('cadastros/clientes/salvar.php');
                    } elseif ($mod == 3) {
                        include('cadastros/clientes/inativa_cad.php');
                    }
                    break;

                case 4: // Download
                    if ($mod == 0) {
                        include('arquivos/download/index.php');
                    }
                    break;
                case 5: // Upload
                    if ($mod == 0) {
                        include('arquivos/upload/index.php');
                    } elseif ($mod == 1) {
                        include('arquivos/upload/processa_arquivos.php');
                    }
                    break;

                case 6: // Cadastro de tipos de mensagem
                    if ($mod == 0) {
                        include('arquivos/cadastro/index.php');
                    } elseif ($mod == 1) {
                        include('arquivos/cadastro/cadastro.php');
                    } elseif ($mod == 2) {
                        include('arquivos/cadastro/salvar.php');
                    } elseif ($mod == 3) {
                        include('arquivos/cadastro/inativa_cad.php');
                    }
                    break;

                default: // Dashboard padrão
                    include('rotinas/dashboard.php');
                    break;
            }
            ?>
        </div>
    </div>

    <!-- Gráficos -->
    <script src="js/chart.js"></script>

    <!-- Datatable -->
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>
    <script src="js/datatables.js"></script>

    <!-- Autocomplete UI -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-ui.js"></script>

    <!-- Mascáras JS -->
    <script src="js/masks.js"></script>

    <!-- AdminLTE -->
    <script src="js/adminlte.min.js"></script>

    <!-- Bootstrap modal -->
    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>
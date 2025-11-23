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
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            padding-top: 30px;
        }

        .sidebar a {
            color: #ddd;
            font-size: 17px;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            margin-left: 230px;
            padding: 20px;
        }

        .topbar {
            background: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-center text-light mb-4">MENU</h4>
        <a href="#"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        <a href="#"><i class="fa-regular fa-user"></i> Cadastros</a>
        <a href="#"><i class="fa-regular fa-folder-open"></i> Arquivos</a>
        <a href="#"><i class="fa-regular fa-circle-question"></i> Ajuda</a>
    </div>

    <div class="content">

        <!-- Topbar -->
        <div class="topbar">
            <span><strong>Bem-vindo, <?php echo $usuario; ?> </strong></span>

            <a href="logout.php" class="btn btn-danger btn-sm">Sair</a>
        </div>

        <h3>Painel Inicial</h3>
        <p>Conteúdo do painel vai aqui...</p>

    </div>

</body>
</html>
<?php

session_start();

require "classes/classe_conexao.php";
$db = new Database();

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe campos
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

    if (!$email) {
        $errors[] = 'Informe um e-mail válido.';
    }
    if (!$password) {
        $errors[] = 'Informe a senha.';
    }

    // Validação via banco
    if (empty($errors)) {

        // Consulta o usuário pelo e-mail
        $usuario = $db->getRegistro("SELECT id_usuario, nm_usuario, nm_email, senha FROM tb_usuarios WHERE nm_email = :email LIMIT 1",[":email" => $email]);

        if (!$usuario) {
            $errors[] = 'Usuário ou senha inválidos.';
        } else {

            // Verifica o hash da senha
            if ($password != $usuario['senha']) {
                $errors[] = 'Usuário ou senha inválidos.';
            } else {

                // Login bem sucedido
                $_SESSION['usuario'] = [
                    'id'        => $usuario['id_usuario'],
                    'email'     => $usuario['nm_email'],
                    'nm_usuario'=> $usuario['nm_usuario'],
                    'logged_at' => time()
                ];

                // Segurança extra
                session_regenerate_id(true);

                header('Location: index.php');
                exit;
            }
        }
    }
}

// HTML abaixo - usa Bootstrap CDN para estilo simples
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Painel de Arquivos</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <style>
        body {
            background: linear-gradient(180deg, #0A4B73, #eef2f6);
            font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(20, 20, 50, 0.06);
        }

        .logo {
            width: 200px;
            margin: 0 auto;
            border-radius: 12px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    
                </div>


                <div class="card p-4">
                    <img src="imagens/logo-empresa.png" alt="" class="logo">
                    <br>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $err): ?>
                                    <li><?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>


                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <i class="fa-regular fa-envelope"></i>
                            <label for="email" class="form-label">E‑mail</label>
                            <input id="email" placeholder="Digite seu email" name="email" type="email" class="form-control"
                                value="<?= htmlspecialchars($email) ?>" required>
                        </div>


                        <div class="mb-3">
                            <i class="fa-solid fa-lock"></i>
                            <label for="password" class="form-label">Senha</label>
                            <input id="password" placeholder="Digite sua senha" name="password" type="password" class="form-control" required>
                        </div>


                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Lembrar-me</label>
                            </div>
                            <a href="#" class="small">Esqueceu a senha?</a>
                        </div>


                        <button class="btn btn-primary w-100" type="submit">Entrar</button>
                    </form>


                    <hr class="my-3">
                    <div class="text-center small text-muted">Contato para ter acesso ao painel</div>
                    <div class="text-center small text-muted">Email: teste@gmail.com // Telefone: 11 99999-9999</div>
                    <div class="text-center small text-muted">© 2025 Vista Consultoria contábil.</div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
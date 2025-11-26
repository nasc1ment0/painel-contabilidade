<?php

session_start();

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

    // Se sem erros, valida usuário de teste
    if (empty($errors)) {

        // Usuários de teste
        $users = [
            'admin@exemplo.com'   => password_hash('senha123', PASSWORD_DEFAULT),
            'cliente@exemplo.com' => password_hash('cliente123', PASSWORD_DEFAULT),
            'teste@exemplo.com'   => password_hash('teste123', PASSWORD_DEFAULT)
        ];

        if (!array_key_exists($email, $users)) {
            $errors[] = 'Usuário ou senha inválidos.';
        } else {

            $hash = $users[$email];

            if (!password_verify($password, $hash)) {
                $errors[] = 'Usuário ou senha inválidos.';
            } else {

                // Login bem sucedido
                $_SESSION['usuario'] = [
                    'email'     => $email,
                    'nm_usuario'=> 'Usuário Teste',
                    'logged_at' => time()
                ];

                // Segurança extra
                session_regenerate_id(true);

                // Redireciona para painel
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
            background-attachment: fixed; /* ← ADICIONE ESTA LINHA */
            background-repeat: no-repeat; /* ← E ESTA */
            font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            overflow: hidden;
            height: 100vh;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(20, 20, 50, 0.06);
        }

        .logo {
            width: 200px;
            margin: 0 auto;
            border-radius: 12px;
            margin-bottom:10px
        }
    </style>
</head>

<body>
    <div class="container py-6">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card p-4">
                    <img src="imagens/logo-empresa.png" alt="" class="logo">
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
                    <div class="text-center small text-muted">© 2025 Vista Consultoria contábil.</div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
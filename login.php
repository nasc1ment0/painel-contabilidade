<?php

session_start();
// Função que retorna usuários de exemplo (substitua por consulta ao banco)
function get_test_users(): array
{
    return [
        'admin@exemplo.com' => password_hash('senha123', PASSWORD_DEFAULT),
        'cliente@exemplo.com' => password_hash('cliente123', PASSWORD_DEFAULT),
    ];
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe campos
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

    if (!$email) {
        $errors[] = 'Informe um e‑mail válido.';
    }
    if (!$password) {
        $errors[] = 'Informe a senha.';
    }


    // Se sem erros, valida usuário
    if (empty($errors)) {
        $users = get_test_users();

        if (!array_key_exists($email, $users)) {
            $errors[] = 'Usuário ou senha inválidos.';
        } else {
            $hash = $users[$email];
            if (!password_verify($password, $hash)) {
                $errors[] = 'Usuário ou senha inválidos.';
            } else {
                // Login bem sucedido
                // Normalmente pegaria dados do DB e guardaria o id do usuário na sessão
                $_SESSION['usuario'] = [
                    'email' => $email,
                    'logged_at' => time(),
                    'nm_usuario' => "Henrique"
                ];


                // Regenerar token de sessão por segurança
                session_regenerate_id(true);

                // Redireciona para painel
                header('Location: index.php');
                exit;
            }
        }
    }
}
;

// HTML abaixo - usa Bootstrap CDN para estilo simples
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Painel de Arquivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(180deg, #f8fafc, #eef2f6);
            font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(20, 20, 50, 0.06);
        }

        .logo {
            font-weight: 700;
            letter-spacing: -0.02em;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <h1 class="logo">Painel - Contabilidade</h1>
                </div>


                <div class="card p-4">
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
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">


                        <div class="mb-3">
                            <label for="email" class="form-label">E‑mail</label>
                            <input id="email" name="email" type="email" class="form-control"
                                value="<?= htmlspecialchars($email) ?>" required>
                        </div>


                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input id="password" name="password" type="password" class="form-control" required>
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
                    <div class="text-center small text-muted">Usuários de teste: admin@exemplo.com / senha123 •
                        cliente@exemplo.com / cliente123</div>
                </div>


                <p class="text-center text-muted mt-3 small">Feito para testes locais — substitua a lógica por consultas
                    ao banco e HTTPS em produção.</p>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar dados
    $id_cliente = $_POST['id_cliente'] ?? '';
    $arquivos = $_FILES['arquivos'] ?? [];

    // Verificar se cliente existe
    $cliente = $db->getRegistro("SELECT id_cliente, nm_cliente, email FROM tb_clientes WHERE id_cliente = :id",[":id" => $id_cliente]);

    if (!$cliente) {
        throw new Exception("Cliente não encontrado");
    }

    // Criar diretório do cliente
    $pastaCliente = "envios/clientes/" . $id_cliente . "/";
    if (!is_dir($pastaCliente)) {
        if (!mkdir($pastaCliente, 0755, true)) {
            throw new Exception("Erro ao criar pasta do cliente");
        }
    }

    $uploadsSucesso = [];
    $uploadsErro = [];

    // Processar múltiplos arquivos
    for ($i = 0; $i < count($arquivos['name']); $i++) {
        if ($arquivos['error'][$i] !== UPLOAD_ERR_OK) {
            $uploadsErro[] = $arquivos['name'][$i] . " - Erro no upload";
            continue;
        }

        // Validar tamanho do arquivo (máximo 10MB)
        if ($arquivos['size'][$i] > 10 * 1024 * 1024) {
            $uploadsErro[] = $arquivos['name'][$i] . " - Arquivo muito grande (máx. 10MB)";
            continue;
        }

        // Sanitizar nome do arquivo
        $nomeArquivo = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $arquivos['name'][$i]);
        $caminhoCompleto = $pastaCliente . $nomeArquivo;

        // Mover arquivo
        if (move_uploaded_file($arquivos['tmp_name'][$i], $caminhoCompleto)) {
            $uploadsSucesso[] = $nomeArquivo;

            $dados = [];
            $dados['id_cliente'] = $id_cliente;
            $dados['nm_caminho'] = $caminhoCompleto;
            $dados['dt_envio'] = date("Y-m-d H:i:s");
            $dados['id_usuario'] = $id_usuario;

            $db->incluir("tb_uploads", $dados);

            $arquivosSalvos[] = [
                'nome' => $nomeArquivo,
                'caminho' => $caminhoCompleto
            ];

        } else {
            $uploadsErro[] = $arquivos['name'][$i] . " - Erro ao salvar arquivo";
        }
    }

    // Preparar mensagem de resultado
    $mensagem = "";
    if (!empty($uploadsSucesso)) {
        $mensagem .= "Uploads bem-sucedidos: " . implode(", ", $uploadsSucesso) . ". ";
    }
    if (!empty($uploadsErro)) {
        $mensagem .= "Erros: " . implode(", ", $uploadsErro);
    }

    $_SESSION['mensagem'] = $mensagem ?: "Nenhum arquivo processado";
    $_SESSION['tipo_mensagem'] = empty($uploadsErro) ? 'success' : 'warning';

    require("envio_email.php");
    // Redirecionar de volta para o formulário
    header("Location: index.php?rotina=5&mod=0");
    exit;
}
?>
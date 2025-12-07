<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar dados
    $id_cliente = $_POST['id_cliente'] ?? '';
    $arquivos = $_FILES['arquivos'] ?? [];

    // Verificar se cliente existe
    $cliente = $db->getRegistro("SELECT id_cliente, nm_cliente, email FROM tb_clientes WHERE id_cliente = :id", [":id" => $id_cliente]);

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

    require("envio_bucket.php");

    for ($i = 0; $i < count($arquivos['name']); $i++) {

        if ($arquivos['error'][$i] !== UPLOAD_ERR_OK) {
            $uploadsErro[] = $arquivos['name'][$i] . " - Erro no upload";
            continue;
        }

        $nomeArquivo = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $arquivos['name'][$i]);
        $arquivoTmp = $arquivos['tmp_name'][$i];

        // ENVIA DIRETO PARA O BUCKET
        $url = enviarParaS3($arquivoTmp, $nomeArquivo, $id_cliente);

        if ($url !== false) {

            $uploadsSucesso[] = $nomeArquivo;

            $dados = [];
            $dados['id_cliente'] = $id_cliente;
            $dados['nm_caminho'] = $url;
            $dados['dt_envio'] = date("Y-m-d H:i:s");
            $dados['id_usuario'] = $id_usuario;

            $retorno = $db->incluir("tb_uploads", $dados);

            $arquivosSalvos[] = [
                'nome' => $nomeArquivo,
                'caminho' => $url
            ];

        } else {
            $uploadsErro[] = $nomeArquivo . " - Erro ao enviar para o S3";
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
    ob_end_clean(); // limpa qualquer saída ANTES do header
    header("Location: index.php?rotina=5&mod=0");
    exit;
}
?>
<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$listaEmails = explode(";", $cliente['email']);
$listaEmails = array_map('trim', $listaEmails);

$mail = new PHPMailer(true);

try {
    // Config SMTP
    $mail->isSMTP();
    $mail->Host = $_ENV['HOST_EMAIL'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['EMAIL_TESTE']; // ou coloque direto se for só teste
    $mail->Password = $_ENV['SENHA_EMAIL_TESTE']; // senha de app do Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Charset = "UTF-8";

    // Remetente e destino
    $mail->setFrom($_ENV['EMAIL_TESTE'], 'Painel Contabilidade Vista');
    $mail->addAddress($listaEmails[0], nm_cliente($id_cliente));

    for ($i = 1; $i < count($listaEmails); $i++) {
        $mail->addCC($listaEmails[$i]);
    }

    $mail->addBCC($_ENV['EMAIL_COPIA']);
    $mail->isHTML(true);
    $mail->Subject = "Novos arquivos compartilhados no painel";
    $mail->Body = "<h4>Olá " . nm_cliente($id_cliente) . ",</h4><p>{$mensagem_email}</p>";

    //Inclusão dos arquivos no email
    foreach ($arquivosSalvos as $arquivo) {
        //salva arquivo da nuvem temporariamente para enviar por email depois
        $tmp = tempnam(sys_get_temp_dir(), 'att_');
        $conteudo = @file_get_contents($arquivo['caminho']);
        file_put_contents($tmp, $conteudo);

        $mail->addAttachment($tmp, utf8_encode($arquivo['nome']));
        $tmpFiles[] = $tmp;
    }
    $mail->send();

    //Apaga os arquivos temporários depois de enviar o email 
    foreach ($tmpFiles as $tmp) {
        @unlink($tmp);
    }

    $dados = [];
    $dados["remetente"] = $_ENV['EMAIL_TESTE'];
    $dados["destinatario"] = $cliente['email'];
    $dados["tp_mensagem"] = $tp_mensagem;
    $dados["body_email"] = utf8_encode($mail->Body);
    $dados["id_cliente"] = $id_cliente;
    $dados["id_usuario"] = $id_usuario;
    $dados["dt_log"] = date("Y-m-d H:i:s");
    $dados["retorno"] = "Email enviado com sucesso!";

    $db->incluir("log_emails", $dados);

} catch (Exception $e) {
    //echo "Erro ao enviar email: {$mail->ErrorInfo}";
    foreach ($tmpFiles as $tmp) {
        @unlink($tmp);
    }

    $dados = [];
    $dados["remetente"] = $_ENV['EMAIL_TESTE'];
    $dados["destinatario"] = $cliente['email'];
    $dados["tp_mensagem"] = $tp_mensagem;
    $dados["body_email"] = utf8_encode($mail->Body);
    $dados["id_cliente"] = $id_cliente;
    $dados["id_usuario"] = $id_usuario;
    $dados["dt_log"] = date("Y-m-d H:i:s");
    $dados["retorno"] = $mail->ErrorInfo;

    $db->incluir("log_emails", $dados);
}
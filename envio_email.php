<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail = new PHPMailer(true);

try {
    // Config SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['EMAIL_TESTE']; // ou coloque direto se for só teste
    $mail->Password = $_ENV['SENHA_EMAIL_TESTE']; // senha de app do Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Charset = "UTF-8";

    // Remetente e destino
    $mail->setFrom($_ENV['EMAIL_TESTE'], 'Painel Contabilidade (Teste)');
    $mail->addAddress($cliente['email'], nm_cliente($id_cliente));

    // Conteúdo
    $mail->isHTML(true);
    $mail->Subject = "Novos arquivos compartilhados no painel";
    $mail->Body = "<h4>Olá " . nm_cliente($id_cliente) . ",</h4><p>Segue em anexo os arquivos enviados através do painel.</p>";
    
    //Inclusão dos arquivos no email
    foreach ($arquivosSalvos as $arquivo) {
        $mail->addAttachment($arquivo['caminho'], $arquivo['nome']);
    }
    $mail->send();
    echo "Email enviado com sucesso! 🎉";

} catch (Exception $e) {
    echo "Erro ao enviar email: {$mail->ErrorInfo}";
}
<?php
require_once __DIR__ . "/vendor/autoload.php";

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$s3 = new S3Client([
    'region' => 'auto',
    'version' => 'latest',
    'endpoint' => $_ENV['ENDPOINT_S3'],
    'use_path_style_endpoint' => true,
    'credentials' => [
        'key'    => $_ENV['KEY_ACESS_S3'],
        'secret' => $_ENV['KEY_ACESS_SECRET_S3'],
    ]
]);

function enviarParaS3($arquivoTmp, $nomeArquivo, $idCliente)
{
    global $s3;

    $bucket = "vistapainel";

    try {
        $result = $s3->putObject([
            'Bucket' => $bucket,
            'Key'    => "clientes/$idCliente/$nomeArquivo",
            'SourceFile' => $arquivoTmp,
            'ACL'    => 'public-read'
        ]);

       return $_ENV['URL_PUBLIC_S3']."clientes/$idCliente/$nomeArquivo";

    } catch (AwsException $e) {
        return false;
    }
}

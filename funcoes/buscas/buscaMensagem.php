<?php
session_start();
require "../../classes/classe_conexao.php";
$db = new Database();
require "../../funcoes/funcoes.php";

header('Content-Type: application/json');

// exemplo usando tabela tb_mensagens
$registros = $db->getRegistros("SELECT id_tp_mensagem, ds_tp_mensagem, texto FROM tb_tp_mensagem WHERE ativo = 'S' ORDER BY ds_tp_mensagem");
$retorno = [];

foreach ($registros as $row) {
    $retorno[] = [
        "id"    => $row["id_tp_mensagem"],
        "nome"  => $row["ds_tp_mensagem"],
        "texto" => $row["texto"]
    ];
}

echo json_encode($retorno);

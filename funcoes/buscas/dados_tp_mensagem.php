<?php
require "../../classes/classe_conexao.php";
$db = new Database();

header('Content-Type: application/json');

// Consulta apenas os 5 Maiores tipos de arquivos
$sql = $db->getRegistros("SELECT ds_tp_mensagem, count(ds_tp_mensagem) AS qtde FROM log_emails GROUP BY ds_tp_mensagem LIMIT 5",[]);

$labels = [];
$values = [];

foreach ($sql as $row) {

    $tp_mensagem  = $row['ds_tp_mensagem'];
    $qtde        = $row['qtde'];

    // Exemplo: Jan/2026
    $labels[] = $tp_mensagem;
    $values[] = $qtde;
}

echo json_encode([
    "labels" => $labels,
    "values" => $values
]);

<?php
require "../../classes/classe_conexao.php";
$db = new Database();

header('Content-Type: application/json');

// Consulta apenas os 5 Maiores tipos de arquivos
$sql = $db->getRegistros("SELECT tp_arquivo, count(tp_arquivo) AS qtde FROM tb_uploads GROUP BY tp_arquivo LIMIT 5",[]);

$labels = [];
$values = [];

foreach ($sql as $row) {

    $tp_arquivo  = $row['tp_arquivo'];
    $qtde        = $row['qtde'];

    // Exemplo: Jan/2026
    $labels[] = $tp_arquivo;
    $values[] = $qtde;
}

echo json_encode([
    "labels" => $labels,
    "values" => $values
]);

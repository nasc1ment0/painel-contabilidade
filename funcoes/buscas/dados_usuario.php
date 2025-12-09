<?php
require "../../classes/classe_conexao.php";
$db = new Database();
require "../funcoes.php";

header('Content-Type: application/json');

// Consulta apenas os 5 usuários que mais fazem upload no sistema
$sql = $db->getRegistros("SELECT id_usuario, count(id_usuario) AS qtde FROM tb_uploads GROUP BY id_usuario LIMIT 5",[]);

$labels = [];
$values = [];

foreach ($sql as $row) {

    $usuario  = nm_usuario($row['id_usuario']);
    $qtde        = $row['qtde'];

    // Exemplo: Jan/2026
    $labels[] = $usuario;
    $values[] = $qtde;
}

echo json_encode([
    "labels" => $labels,
    "values" => $values
]);

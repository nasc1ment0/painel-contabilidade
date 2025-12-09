<?php
require "../../classes/classe_conexao.php";
$db = new Database();

header('Content-Type: application/json');

// Consulta apenas os últimos 5 meses
$sql = $db->getRegistros("SELECT DATE_FORMAT(dt_envio, '%m') AS mes_num,DATE_FORMAT(dt_envio, '%Y') AS ano, COUNT(*) AS total FROM tb_uploads 
    WHERE dt_envio >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH)
    GROUP BY ano, mes_num
    ORDER BY ano, mes_num",[]);

$labels = [];
$values = [];

$meses = ["", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];

foreach ($sql as $row) {

    $mesNum = $row['mes_num'];
    $ano    = $row['ano'];

    // Exemplo: Jan/2026
    $labels[] = $meses[$mesNum] . "/" . $ano;
    $values[] = (int)$row['total'];
}

echo json_encode([
    "labels" => $labels,
    "values" => $values
]);

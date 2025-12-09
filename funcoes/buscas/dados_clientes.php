<?php
require "../../classes/classe_conexao.php";
$db = new Database();
require "../funcoes.php";

header('Content-Type: application/json');

// Busca quantidade de clientes PJ e PF
$sql = $db->getRegistros("SELECT tp_cliente,COUNT(*) AS total FROM tb_clientes GROUP BY tp_cliente", []);

$totalPJ = 0;
$totalPF = 0;

foreach ($sql as $row) {
    if ($row['tp_cliente'] == "J") {
        $totalPJ = $row['total'];
    } else if ($row['tp_cliente'] == "F") {
        $totalPF = $row['total'];
    }
}

// Soma total
$totalClientes = $totalPJ + $totalPF;

// Evita divisão por zero
if ($totalClientes == 0) {
    $percentPJ = 0;
    $percentPF = 0;
} else {
    $percentPJ = round(($totalPJ / $totalClientes) * 100, 2);
    $percentPF = round(($totalPF / $totalClientes) * 100, 2);
}

echo json_encode([
    "labels" => ["Pessoa Jurídica", "Pessoa Física"],
    "values" => [$percentPJ, $percentPF]
]);

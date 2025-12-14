<?php
require "../../classes/classe_conexao.php";
$db = new Database();
require "../funcoes.php";
// Valores enviados pelo DataTables
$draw   = $_POST['draw'];
$start  = $_POST['start'];
$length = $_POST['length'];
$search = $_POST['search']['value'] ?? "";
$where = "";
$params = [];
$orderDir = 'DESC';

if (isset($_POST['order'][0]['dir']) && in_array(strtolower($_POST['order'][0]['dir']), ['asc', 'desc'])) {
    $orderDir = strtoupper($_POST['order'][0]['dir']);
}


// TOTAL sem filtro
$totalQuery = $db->getRegistro("SELECT COUNT(*) as total FROM log_emails", []);
$totalRegistros = $totalQuery["total"];

if (!empty($search)) {
    $where = " AND (ds_tp_mensagem LIKE :s OR dt_log LIKE :s OR destinatario LIKE :s OR body_email LIKE :s)";
    $params[":s"] = "%$search%";
}

// TOTAL filtrado
$filteredQuery = $db->getRegistro("SELECT COUNT(*) as total FROM log_emails WHERE 1 $where", $params);
$totalFiltrado = $filteredQuery["total"];

// CONSULTA PRINCIPAL
$sql = "SELECT destinatario, body_email, ds_tp_mensagem, id_cliente, id_usuario, dt_log FROM log_emails WHERE 1 $where ORDER BY dt_log $orderDir LIMIT $start, $length";
$dados = $db->getRegistros($sql, $params);

// MONTAR ARRAY PARA O DATATABLES
$resultado = [];

foreach ($dados as $row) {
    $resultado[] = [
        "tipo_mensagem" => $row["ds_tp_mensagem"],
        "texto"         => strip_tags(trim(substr($row["body_email"], strpos($row["body_email"], ',') + 1))),
        "cliente"       => nm_cliente($row["id_cliente"]),
        "usuario"       => nm_usuario($row["id_usuario"]),
        "data_envio"    => date("d/m/Y H:i:s", strtotime($row["dt_log"]))
    ];
}

// RETORNO FINAL
echo json_encode([
    "draw" => intval($draw),
    "recordsTotal" => intval($totalRegistros),
    "recordsFiltered" => intval($totalFiltrado),
    "data" => $resultado
]);

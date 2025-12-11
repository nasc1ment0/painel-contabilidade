<?php
require "../../classes/classe_conexao.php";
$db = new Database();

$id_cliente = $_GET["id_cliente"] ?? 0;

// Valores enviados pelo DataTables
$draw   = $_POST['draw'];
$start  = $_POST['start'];
$length = $_POST['length'];
$search = $_POST['search']['value'] ?? "";


// TOTAL sem filtro
$totalQuery = $db->getRegistro("SELECT COUNT(*) as total FROM tb_uploads WHERE id_cliente = :id", [":id" => $id_cliente]);

$totalRegistros = $totalQuery["total"];

// FILTRO (pesquisa)
$where = " WHERE id_cliente = :id ";
$params = [":id" => $id_cliente];

if (!empty($search)) {
    $where .= " AND (nm_caminho LIKE :s OR dt_envio LIKE :s OR id_upload LIKE :s)";
    $params[":s"] = "%$search%";
}

// TOTAL filtrado
$filteredQuery = $db->getRegistro("SELECT COUNT(*) as total FROM tb_uploads $where", $params);
$totalFiltrado = $filteredQuery["total"];

// CONSULTA PRINCIPAL
$sql = "SELECT id_upload, nm_caminho, dt_envio FROM tb_uploads $where LIMIT $start, $length";

$dados = $db->getRegistros($sql, $params);

// MONTAR ARRAY PARA O DATATABLES
$resultado = [];

foreach ($dados as $row) {
    $resultado[] = [
        "id_upload" => $row["id_upload"],
        "arquivo"   => basename($row["nm_caminho"]),
        "data"      => date("d/m/Y H:i:s", strtotime($row["dt_envio"])),
        "acoes"     => '<a href="'.$row['nm_caminho'].'" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-download"></i></a>'
    ];
}

// RETORNO FINAL
echo json_encode([
    "draw" => intval($draw),
    "recordsTotal" => intval($totalRegistros),
    "recordsFiltered" => intval($totalFiltrado),
    "data" => $resultado
]);

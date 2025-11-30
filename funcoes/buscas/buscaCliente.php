<?php
session_start();
require "../../classes/classe_conexao.php";
$db = new Database();
require "../../funcoes/funcoes.php";

$termo = $_GET['termo'] ?? '';
$resultado = [];

if (strlen($termo) >= 2) {
    $clientes = $db->getRegistros("SELECT id_cliente, nm_cliente, nr_documento FROM tb_clientes 
                                        WHERE (nm_cliente LIKE :termo  OR nr_documento LIKE :termo) ORDER BY nm_cliente LIMIT 10", [":termo" => "%$termo%"]);
    foreach($clientes as $c){
        $resultado = [
            "id_cliente" => $c["id_cliente"],
            "label" => $c["nm_cliente"]. " - " .maskDocumento($c["nr_documento"])
        ];
    }

    echo json_encode($resultado, JSON_UNESCAPED_SLASHES);
} else {
    echo json_encode([]);
}
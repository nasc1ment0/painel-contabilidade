<?php

$id = $_GET["id"] ?? null;
$ativo = $_GET["ativo"] ?? null;
$texto = $_GET["ativo"] == "S" ? "Ativado" : "Inativado";


$alterar = $db->alterar("tb_clientes", ["ativo" => $ativo], "id_cliente = $id");
exit("<script>alert('Cliente $id foi $texto!'); location = 'index.php?rotina=3&mod=0'</script>");

?>
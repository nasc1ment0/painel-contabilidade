<?php

$id = $_GET["id"] ?? null;
$ativo = $_GET["ativo"] ?? null;
$texto = $_GET["ativo"] == "S" ? "Ativado" : "Inativado";


$alterar = $db->alterar("tb_tp_mensagem", ["ativo" => $ativo], "id_tp_mensagem = $id");
exit("<script>alert('Tipo de mensagem $id foi $texto!'); location = 'index.php?rotina=6&mod=0'</script>");

?>
<?php

$id = $_GET["id"] ?? null;
$ativo = $_GET["ativo"] ?? null;
$texto = $_GET["ativo"] == "S" ? "Ativado" : "Inativado";


$alterar = $db->alterar("tb_usuarios", ["ativo" => $ativo], "id_usuario = $id");
exit("<script>alert('Usuário $id foi $texto!'); location = 'index.php?rotina=2&mod=0'</script>");

?>
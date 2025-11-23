<?php

$id = $_GET["id"] ?? null;
$ativo = $_GET["ativo"] ?? null;
$texto = $_GET["ativo"] == "S" ? "Ativado" : "Inativado";


$alterar = $db->alterar("tb_tp_acessos", ["ativo" => $ativo], "id_tp_acesso = $id");
exit("<script>alert('Tipo de acesso $id foi $texto!'); location = 'index.php?rotina=1&mod=0'</script>");

?>
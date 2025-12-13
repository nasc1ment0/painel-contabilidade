<?php
$id = $_POST["id"] ?? null;

$dados = [];

$dados["ds_tp_mensagem"] = $_POST["ds_tp_mensagem"];
$dados["texto"] = $_POST["texto"];
$dados["id_usuario"] = $id_usuario;



if($id == 0){
    $retorno = $db->incluir("tb_tp_mensagem", $dados);
    exit("<script>alert('Tipo de mensagem {$_POST['ds_tp_mensagem']} foi incluso! ID: $retorno'); location = 'index.php?rotina=6&mod=0'</script>");
}else{
    $alterar = $db->alterar("tb_tp_mensagem", $dados, "id_tp_mensagem = $id");
    exit("<script>alert('Tipo de mensagem $id foi Alterado!'); location = 'index.php?rotina=6&mod=0'</script>");
}
?>
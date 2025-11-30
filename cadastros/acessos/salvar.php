<?php
$id = $_POST["id"] ?? null;

if($id == 0){
    $dados = [];

    $dados["ds_tp_acesso"] = $_POST["ds_tp_acesso"];
    $dados["op_altera_cadastro"] = $_POST["op_altera_cadastro"];
    $dados["op_dashboard"] = $_POST["op_dashboard"];
    $dados["op_acesso_rotinas"] = $_POST["op_acesso_rotinas"];
    $dados["id_usuario"] = $id_usuario;


    $retorno = $db->incluir("tb_tp_acessos", $dados);
   
    exit("<script>alert('Tipo de acesso {$_POST['ds_tp_acesso']} foi incluso! ID: $retorno'); location = 'index.php?rotina=1&mod=0'</script>");
}else{
    $dados = [];

    $dados["ds_tp_acesso"] = $_POST["ds_tp_acesso"];
    $dados["op_altera_cadastro"] = $_POST["op_altera_cadastro"];
    $dados["op_dashboard"] = $_POST["op_dashboard"];
    $dados["op_acesso_rotinas"] = $_POST["op_acesso_rotinas"];
    $dados["id_usuario"] = $id_usuario;

    $alterar = $db->alterar("tb_tp_acessos", $dados, "id_tp_acesso = $id");

    exit("<script>alert('Tipo de acesso $id foi Alterado!'); location = 'index.php?rotina=1&mod=0'</script>");
}
?>
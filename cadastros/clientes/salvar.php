<?php
$id = $_POST["id"] ?? null;

$dados = [];

$dados["nm_cliente"] = $_POST["nm_cliente"];
$dados["tp_cliente"] = $_POST["tp_cliente"];
$dados["nr_documento"] = limpa_texto($_POST["nr_documento"]);
$dados["email"] = $_POST["email"];
$dados["contato_cliente"] = $_POST["nm_contato"];
$dados["nr_tel"] = limpa_texto($_POST["nr_tel"]);
$dados["nr_cel"] = limpa_texto($_POST["nr_cel"]);


if($id == 0){

    //Verifica se não existe nenhum usuário com o mesmo documento já cadastrado.
    $clientes = $db->getRegistro("SELECT nr_documento FROM tb_clientes WHERE nr_documento = :doc", [":doc" => limpa_texto($_POST["nr_documento"])]);
    if(isset($clientes['nr_documento'])){
        exit("<script>alert('Documento já existe em outro Cliente, Ação cancelada'); location = 'index.php?rotina=3&mod=0'</script>");
    }

    $retorno = $db->incluir("tb_clientes", $dados);
    exit("<script>alert('Cliente {$_POST['nm_cliente']} foi incluso! ID: $retorno'); location = 'index.php?rotina=3&mod=0'</script>");
}else{

    //Verifica se não existe nenhum usuário com o mesmo documento já cadastrado (EXCETO O PRÓPRIO CLIENTE QUE ESTÁ SENDO ALTERADO).
    $clientes = $db->getRegistro("SELECT nr_documento FROM tb_clientes WHERE nr_documento = :doc AND id_cliente != :id", [":doc" => limpa_texto($_POST["nr_documento"]), ":id" => $id]);
    if(isset($clientes['nr_documento'])){
        exit("<script>alert('Documento já existe em outro cliente, Ação cancelada'); location = 'index.php?rotina=3&mod=0'</script>");
    }

    $alterar = $db->alterar("tb_clientes", $dados, "id_cliente = $id");
    exit("<script>alert('Cliente $id foi Alterado!'); location = 'index.php?rotina=3&mod=0'</script>");
}
?>
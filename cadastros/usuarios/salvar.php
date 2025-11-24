<?php
$id = $_POST["id"] ?? null;

$dados = [];

$dados["nm_usuario"] = $_POST["nm_usuario"];
$dados["nm_email"] = $_POST["nm_email"];
$dados["senha"] = password_hash($_POST["senha"], PASSWORD_DEFAULT);
$dados["id_acesso"] = $_POST["id_acesso"];



if($id == 0){

    //Verifica se não existe nenhum usuário com o mesmo email já cadastrado.
    $usuarios = $db->getRegistro("SELECT nm_email FROM tb_usuarios WHERE nm_email = :email", [":email" => trim($_POST["nm_email"])]);
    if(isset($usuarios['nm_email'])){
        exit("<script>alert('Email já existe em outro usuário, Ação cancelada'); location = 'index.php?rotina=2&mod=0'</script>");
    }

    $retorno = $db->incluir("tb_usuarios", $dados);
    exit("<script>alert('Usuário {$_POST['nm_usuario']} foi incluso! ID: $retorno'); location = 'index.php?rotina=2&mod=0'</script>");
}else{

    //Verifica se não existe nenhum usuário com o mesmo email já cadastrado (EXCETO O PRÓPRIO USUÁRIO QUE ESTÁ SENDO ALTERADO).
    $usuarios = $db->getRegistro("SELECT nm_email FROM tb_usuarios WHERE nm_email = :email AND id_usuario != :id", [":email" => trim($_POST["nm_email"]), ":id" => $id]);
    if(isset($usuarios['nm_email'])){
        exit("<script>alert('Email já existe em outro usuário, Ação cancelada'); location = 'index.php?rotina=2&mod=0'</script>");
    }

    $alterar = $db->alterar("tb_usuarios", $dados, "id_usuario = $id");
    exit("<script>alert('Usuário $id foi Alterado!'); location = 'index.php?rotina=2&mod=0'</script>");
}
?>
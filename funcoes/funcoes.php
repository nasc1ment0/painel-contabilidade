<?php
function buscaAcesso($id){
    global $db;
    $acesso = $db->getRegistro("SELECT ds_tp_acesso FROM tb_tp_acessos WHERE id_tp_acesso = :id",[":id" => $id]);
    return $acesso["ds_tp_acesso"];
}

?>
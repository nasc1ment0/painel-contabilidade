<?php
function buscaAcesso($id){
    global $db;
    $acesso = $db->getRegistro("SELECT ds_tp_acesso FROM tb_tp_acessos WHERE id_tp_acesso = :id",[":id" => $id]);
    return $acesso["ds_tp_acesso"];
}

function maskDocumento($doc) {
    // Remove tudo que não é número
    $doc = preg_replace('/[^0-9]/', '', $doc);
    
    if (strlen($doc) == 11) {
        // CPF: 000.000.000-00
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $doc);
    } elseif (strlen($doc) == 14) {
        // CNPJ: 00.000.000/0000-00
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $doc);
    }
    
    // Retorna sem formatação se não for CPF/CNPJ válido
    return $doc;
}
?>
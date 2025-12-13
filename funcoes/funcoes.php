<?php
function buscaAcesso($id)
{
    global $db;
    $acesso = $db->getRegistro("SELECT ds_tp_acesso FROM tb_tp_acessos WHERE id_tp_acesso = :id", [":id" => $id]);
    return $acesso["ds_tp_acesso"];
}

function maskDocumento($doc)
{
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


function maskTelefone($telefone)
{
    // Remove tudo que não é número
    $telefone = preg_replace('/[^0-9]/', '', $telefone);

    // Verifica se é celular (11 dígitos) ou fixo (10 dígitos)
    if (strlen($telefone) == 11) {
        // Celular: (00) 00000-0000
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
    } elseif (strlen($telefone) == 10) {
        // Fixo: (00) 0000-0000
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    } else {
        // Retorna o original se não for telefone válido
        return $telefone;
    }
}

function limpa_texto($valor)
{
    // Remove tudo que não é número
    return preg_replace('/[^0-9]/', '', $valor);
}

function nm_cliente($id)
{
    global $db;
    $usuario = $db->getRegistro("SELECT nm_cliente FROM tb_clientes WHERE id_cliente = :id", [":id" => $id]);
    return $usuario["nm_cliente"];
}

function ds_mensagem($id)
{
    global $db;
    $mensagem = $db->getRegistro("SELECT ds_tp_mensagem FROM tb_tp_mensagem WHERE id_tp_mensagem = :id", [":id" => $id]);
    return $mensagem["ds_tp_mensagem"];
}

function nm_usuario($id)
{
    global $db;
    $usuario = $db->getRegistro("SELECT nm_usuario FROM tb_usuarios WHERE id_usuario = :id", [":id" => $id]);
    return $usuario["nm_usuario"];
}
?>
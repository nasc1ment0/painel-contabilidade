<?php
$id = $_GET["id"] ?? 0;
$id_cliente = $db->getRegistro("SELECT * FROM tb_clientes WHERE id_cliente = :id", [":id" => $id]);
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-user-tie"></i> <?= $id != 0 ? "Alterar Cliente" : "Novo Cliente" ?>
        </h5>
    </div>
    <div class="card-body">
        <form id="formCliente" method="POST" action="index.php?rotina=3&mod=2">
            <input type="hidden" name="id" value="<?= $id ?>">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="nome_cliente" class="form-label">Nome do cliente <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nome_cliente" name="nm_cliente" 
                               value="<?= isset($id_cliente["nm_cliente"]) && $id_cliente["nm_cliente"] != "" ? $id_cliente["nm_cliente"] : "" ?>" 
                               required placeholder="Digite o nome completo ou razão social" maxlength="100">
                    </div>
                </div>
            </div>

           <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tipo_cliente" class="form-label">Tipo do cliente <span class="text-danger">*</span></label>
                        <select class="form-select" id="tipo_cliente" name="tp_cliente" required onchange="mudarTipoDocumento()">
                            <option value="">Selecione o tipo</option>
                            <option value="F" <?= (isset($id_cliente["tp_cliente"]) && $id_cliente["tp_cliente"] == "F") ? 'selected' : '' ?>>Pessoa Física</option>
                            <option value="J" <?= (isset($id_cliente["tp_cliente"]) && $id_cliente["tp_cliente"] == "J") ? 'selected' : '' ?>>Pessoa Jurídica</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="documento" class="form-label">Documento <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="documento" name="nr_documento" 
                            value="<?= isset($id_cliente["nr_documento"]) && $id_cliente["nr_documento"] != "" ? maskDocumento($id_cliente["nr_documento"]) : "" ?>" 
                            required placeholder="Selecione o tipo primeiro" maxlength="18" 
                            <?= isset($id_cliente["nr_documento"]) && $id_cliente["nr_documento"] != "" ? "readonly" : "disabled"?>
                            minlength="11">
                        <div class="form-text" id="doc-info">Mínimo 11 caracteres</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= isset($id_cliente["email"]) && $id_cliente["email"] != "" ? $id_cliente["email"] : "" ?>" 
                               required placeholder="exemplo@email.com" maxlength="100">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="contato_principal" class="form-label">Nome do Contato Principal</label>
                        <input type="text" class="form-control" id="contato_principal" name="nm_contato" 
                               value="<?= isset($id_cliente["contato_cliente"]) && $id_cliente["contato_cliente"] != "" ? $id_cliente["contato_cliente"] : "" ?>" 
                               placeholder="Nome da pessoa para contato" maxlength="100">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telefone_fixo" class="form-label">Número de Telefone (Fixo)</label>
                        <input type="text" class="form-control maskTel" id="telefone_fixo" name="nr_tel" 
                               value="<?= isset($id_cliente["nr_tel"]) && $id_cliente["nr_tel"] != "" ? maskTelefone($id_cliente["nr_tel"]) : "" ?>" 
                               placeholder="(00) 0000-0000" maxlength="14">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="celular" class="form-label">Número de Celular (Whatsapp)</label>
                        <input type="text" class="form-control maskCel" id="celular" name="nr_cel" 
                               value="<?= isset($id_cliente["nr_cel"]) && $id_cliente["nr_cel"] != "" ? maskTelefone($id_cliente["nr_cel"]) : "" ?>" 
                               placeholder="(00) 00000-0000" maxlength="15">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="index.php?rotina=3&mod=0" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?= $id != 0 ? "Atualizar Cliente" : "Cadastrar Cliente" ?>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function mudarTipoDocumento() {
    const tipo = document.getElementById('tipo_cliente').value;
    const docInput = document.getElementById('documento');
    const docInfo = document.getElementById('doc-info');
    
    // Remove todas as classes
    docInput.classList.remove('mask-cpf', 'mask-cnpj');
    
    if (tipo === 'F') {
        docInput.disabled = false;
        docInput.classList.add('mask-cpf');
        docInput.placeholder = '000.000.000-00';
        docInput.maxLength = 14;
        docInput.minLength = 11; 
        docInfo.textContent = 'CPF precisa ter 11 dígitos';
        
    } else if (tipo === 'J') {
        docInput.disabled = false;
        docInput.classList.add('mask-cnpj');
        docInput.placeholder = '00.000.000/0000-00';
        docInput.maxLength = 18;
        docInput.minLength = 14; 
        docInfo.textContent = 'CNPJ precisa ter 14 dígitos';
        
    } else {
        docInput.disabled = true;
        docInput.placeholder = 'Selecione o tipo primeiro';
        docInput.value = '';
        docInput.minLength = 0;
        docInfo.textContent = 'Mínimo 11 caracteres';
    }
}

// Validação no submit do formulário
document.getElementById('formCliente').addEventListener('submit', function(e) {
    const tipo = document.getElementById('tipo_cliente').value;
    const documento = document.getElementById('documento').value.replace(/\D/g, '');
    
    if (tipo === 'F' && documento.length !== 11) {
        e.preventDefault();
        alert('CPF deve ter 11 dígitos');
        return false;
    }
    
    if (tipo === 'J' && documento.length !== 14) {
        e.preventDefault();
        alert('CNPJ deve ter 14 dígitos');
        return false;
    }
});

</script>

<style>
.form-check-label {
    font-weight: 500;
    cursor: pointer;
}

.form-check-input {
    cursor: pointer;
}

.form-check-input:checked {
    background-color: #34495e;
    border-color: #34495e;
}

.card {
    margin: 0 auto;
}
</style>
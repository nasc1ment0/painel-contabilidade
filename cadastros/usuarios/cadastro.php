<?php
$id = $_GET["id"] ?? 0;
$id_usuario = $db->getRegistro("SELECT * FROM tb_usuarios WHERE id_usuario = :id", [":id" => $id]);

// Buscar tipos de acesso para o select
$tipos_acesso = $db->getRegistros("SELECT id_tp_acesso, ds_tp_acesso FROM tb_tp_acessos WHERE ativo = 'S' ORDER BY ds_tp_acesso");

?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-user-plus"></i> <?= $id != 0 ? "Alterar Usuário" : "Novo Usuário" ?>
        </h5>
    </div>
    <div class="card-body">
        <form id="formUsuario" method="POST" action="index.php?rotina=2&mod=2">
            <input type="hidden" name="id" value="<?= $id ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome_usuario" class="form-label">Nome do usuário <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nome_usuario" name="nm_usuario" 
                               value="<?= isset($id_usuario["nm_usuario"]) && $id_usuario["nm_usuario"] != "" ? $id_usuario["nm_usuario"] : "" ?>" 
                               required placeholder="Digite o nome do usuário" maxlength="50">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="nm_email" 
                               value="<?= isset($id_usuario["nm_email"]) && $id_usuario["nm_email"] != "" ? $id_usuario["nm_email"] : "" ?>" 
                               required placeholder="exemplo@email.com" maxlength="50">
                    </div>
                </div>
            </div>

            <?php if($id == 0){ ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="senha" class="form-label">
                            Senha <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control" id="senha" name="senha" value="<?= isset($id_usuario["senha"]) && $id_usuario["senha"] != "" ? $id_usuario["senha"] : "" ?>" placeholder="Digite a senha" minlength="6" required>
                        <div class="form-text">Mínimo 6 caracteres</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">
                            Confirmar Senha <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" value="<?= isset($id_usuario["senha"]) && $id_usuario["senha"] != "" ? $id_usuario["senha"] : "" ?>" required placeholder="Digite a senha novamente">
                    </div>
                </div>
            </div>
            <?php }?>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tipo_acesso" class="form-label">Tipo de acesso <span class="text-danger">*</span></label>
                        <select class="form-select" id="tipo_acesso" name="id_acesso" required>
                            <option value="">Selecione um tipo de acesso</option>
                            <?php foreach($tipos_acesso as $tipo): ?>
                                <option value="<?= $tipo['id_tp_acesso'] ?>" <?= (isset($id_usuario["id_acesso"]) && $id_usuario["id_acesso"] == $tipo['id_tp_acesso']) ? 'selected' : '' ?>><?= $tipo['ds_tp_acesso'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="index.php?rotina=2&mod=0" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?= $id != 0 ? "Atualizar Usuário" : "Cadastrar Usuário" ?>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Validação em tempo real da confirmação de senha
document.getElementById('confirmar_senha').addEventListener('input', function() {
    const senha = document.getElementById('senha').value;
    const confirmar = this.value;
    
    if (confirmar === '') {
        this.classList.remove('is-valid', 'is-invalid');
        return;
    }
    
    if (senha === confirmar) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
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

.is-valid {
    border-color: #198754;
}

.is-invalid {
    border-color: #dc3545;
}

.card {
    margin: 0 auto;
}
</style>
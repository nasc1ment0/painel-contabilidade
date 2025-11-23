<?php
$id = $_GET["id"] != 0 ? $_GET["id"] : 0;
$id_acesso = $db->getRegistro("SELECT*FROM tb_tp_acessos WHERE id_tp_acesso = :id", [":id" => $id])
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus-circle"></i> <?= $id != 0 ? "Alterar Tipo de Acesso" : "Novo Tipo de Acesso" ?>
        </h5>
    </div>
    <div class="card-body">
        <form id="formAcesso" method="POST" action="index.php?rotina=1&mod=2">
            <input type="hidden" name="id" value="<?=$id?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="nome_acesso" class="form-label">Nome do acesso <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nome_acesso" name="ds_tp_acesso" value="<?= isset($id_acesso["ds_tp_acesso"]) && $id_acesso["ds_tp_acesso"] != "" ? $id_acesso["ds_tp_acesso"] : "" ?>" required placeholder="Digite o nome do tipo de acesso" maxlength="100">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Permissão para alterar Cadastros <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="op_altera_cadastro" id="cadastros_s" value="S" <?= isset($id_acesso["op_altera_cadastro"]) && $id_acesso["op_altera_cadastro"] == "S" ? "Checked" : "" ?> required>
                            <label class="form-check-label" for="cadastros_s">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="op_altera_cadastro" id="cadastros_n" value="N" <?= isset($id_acesso["op_altera_cadastro"]) && $id_acesso["op_altera_cadastro"] == "N" ? "Checked" : "" ?>>
                            <label class="form-check-label" for="cadastros_n">Não</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Permissão para acessar Dashboard <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="op_dashboard" id="dashboard_s" value="S" <?= isset($id_acesso["op_dashboard"]) && $id_acesso["op_dashboard"] == "S" ? "Checked" : "" ?> required>
                            <label class="form-check-label" for="dashboard_s">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="op_dashboard" id="dashboard_n" value="N" <?= isset($id_acesso["op_dashboard"]) && $id_acesso["op_dashboard"] == "N" ? "Checked" : "" ?>>
                            <label class="form-check-label" for="dashboard_n">Não</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Permissão de Acesso as Rotinas de envio de arquivo <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="op_acesso_rotinas" id="arquivos_s" value="S" <?= isset($id_acesso["op_acesso_rotinas"]) && $id_acesso["op_acesso_rotinas"] == "S" ? "Checked" : "" ?> required>
                            <label class="form-check-label" for="arquivos_s">
                                 Sim
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="op_acesso_rotinas" id="arquivos_n" value="N" <?= isset($id_acesso["op_acesso_rotinas"]) && $id_acesso["op_acesso_rotinas"] == "N" ? "Checked" : "" ?>>
                            <label class="form-check-label" for="arquivos_n">
                                Não
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="index.php?rotina=1&mod=0" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Tipo de Acesso
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

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
    border-color: #34495e;
}

.is-invalid {
    border-color: #dc3545;
}


</style>
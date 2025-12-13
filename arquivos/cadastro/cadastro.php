<?php
$id = $_GET["id"] ?? 0;
$mensagem = [];

if ($id != 0) {
    $mensagem = $db->getRegistro("SELECT * FROM tb_tp_mensagem WHERE id_tp_mensagem = :id",[":id" => $id]);
}
?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-envelope"></i>
            <?= $id != 0 ? "Alterar Mensagem" : "Nova Mensagem" ?>
        </h5>
    </div>

    <div class="card-body">
        <form method="POST" action="index.php?rotina=6&mod=2">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="mb-3">
                <label class="form-label">
                    Tipo de mensagem <span class="text-danger">*</span>
                </label>
                <input type="text" name="ds_tp_mensagem" class="form-control" required maxlength="50" placeholder="Ex: DAS, BALANÇO, ETC..." value="<?= $mensagem['ds_tp_mensagem'] ?? '' ?>">
            </div>

            <div class="mb-4">
                <label class="form-label">
                    Texto da mensagem <span class="text-danger">*</span>
                </label>
                <textarea name="texto" class="form-control" rows="6" required placeholder="Digite aqui o texto que será enviado ao cliente..."><?= $mensagem['texto'] ?? '' ?></textarea>
            </div>

            <!-- BOTÕES -->
            <div class="d-flex justify-content-between">
                <a href="index.php?rotina=6&mod=0" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <?= $id != 0 ? "Atualizar" : "Salvar" ?>
                </button>
            </div>
        </form>
    </div>
</div>
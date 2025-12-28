<?php

$clientes = $db->getRegistros("SELECT id_cliente, nm_cliente, email, nr_documento, ativo FROM tb_clientes");

?>
<div class="card">
    <div class="card-header d-flex  align-items-center">
        <h5 class="card-title mb-0">Tabela de Clientes</h5>
        <div class="ms-auto">
            <a href="index.php?rotina=3&mod=1&id=0" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Cliente
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablePadrao">
                <thead class="table-dark">
                    <tr>
                        <th width="80">ID</th>
                        <th>Nome</th>
                        <th>CPF/CNPJ</th>
                        <th>Ativo?</th>
                        <th width="150">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($clientes as $c) {
                        $classe = $c['ativo'] == "S" ? "" : "table-danger";
                        ?>
                        <tr class="<?= $classe ?>">
                            <td><?= $c['id_cliente'] ?></td>
                            <td><?= $c['nm_cliente'] ?></td>
                            <td><?= maskDocumento($c['nr_documento']) ?></td>
                            <td><?= $c['ativo'] == "S" ? "Sim" : "Não" ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="index.php?rotina=3&mod=1&id=<?= $c['id_cliente'] ?>" class="btn btn-warning"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($c['ativo'] == "S") { ?>
                                        <a href="index.php?rotina=3&mod=3&id=<?= $c['id_cliente'] ?>&ativo=N"
                                            class="btn btn-danger" title="Inativar">
                                            <i class="fa-regular fa-circle-xmark "></i>
                                        </a>
                                    <?php } else { ?>
                                        <a href="index.php?rotina=3&mod=3&id=<?= $c['id_cliente'] ?>&ativo=S"
                                            class="btn btn-success" title="Ativar">
                                            <i class="fa-regular fa-circle-check"></i>
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
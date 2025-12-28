<?php

$acessos = $db->getRegistros("SELECT id_tp_acesso, ds_tp_acesso, ativo FROM tb_tp_acessos");

?>
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">Tabela de tipos de acesso</h5>

        <div class="ms-auto">
            <a href="index.php?rotina=1&mod=1" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Novo Tipo de Acesso
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablePadrao">
                <thead class="table-dark">
                    <tr>
                        <th width="80">ID</th>
                        <th>Tipo de Acesso</th>
                        <th>Ativo?</th>
                        <th width="150">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($acessos as $a){
                       $classe = $a['ativo'] == "S" ? "" : "table-danger";   
                    ?>
                    <tr class="<?=$classe?>">
                        <td><?= $a['id_tp_acesso'] ?></td>
                        <td><?= $a['ds_tp_acesso'] ?></td>
                        <td><?= $a['ativo'] == "S" ? "Sim" : "Não" ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="index.php?rotina=1&mod=1&id=<?=$a['id_tp_acesso']?>" class="btn btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if($a['ativo'] == "S"){?>
                                <a href="index.php?rotina=1&mod=3&id=<?=$a['id_tp_acesso']?>&ativo=N" class="btn btn-danger" title="Inativar">
                                    <i class="fa-regular fa-circle-xmark "></i>
                                </a>
                                <?php }else{?>
                                <a href="index.php?rotina=1&mod=3&id=<?=$a['id_tp_acesso']?>&ativo=S" class="btn btn-success" title="Ativar">
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
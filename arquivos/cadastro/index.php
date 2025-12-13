<?php

$tp_mensagem = $db->getRegistros("SELECT id_tp_mensagem, ds_tp_mensagem, texto, ativo FROM tb_tp_mensagem");

?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Tabela de Tipos de Mensagem</h5>
        <a href="index.php?rotina=6&mod=1&id=0" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Novo Tipo de Mensagem
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablePadrao">
                <thead class="table-dark">
                    <tr>
                        <th width="80">ID</th>
                        <th>Tipo de mensagem</th>
                        <th>Ativo?</th>
                        <th width="150">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($tp_mensagem as $t){
                       $classe = $t['ativo'] == "S" ? "" : "table-danger";   
                    ?>
                    <tr class="<?=$classe?>">
                        <td><?= $t['id_tp_mensagem'] ?></td>
                        <td><?= $t['ds_tp_mensagem'] ?></td>
                        <td><?= $t['ativo'] == "S" ? "Sim" : "Não" ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="index.php?rotina=6&mod=1&id=<?=$t['id_tp_mensagem']?>" class="btn btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if($t['ativo'] == "S"){?>
                                <a href="index.php?rotina=6&mod=3&id=<?=$t['id_tp_mensagem']?>&ativo=N" class="btn btn-danger" title="Inativar">
                                    <i class="fa-regular fa-circle-xmark "></i>
                                </a>
                                <?php }else{?>
                                <a href="index.php?rotina=6&mod=3&id=<?=$t['id_tp_mensagem']?>&ativo=S" class="btn btn-success" title="Ativar">
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
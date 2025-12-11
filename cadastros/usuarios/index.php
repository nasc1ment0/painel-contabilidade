<?php

$usuarios = $db->getRegistros("SELECT id_usuario, nm_usuario, nm_email, id_acesso, ativo FROM tb_usuarios");

?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Tabela de Usuários</h5>
        <a href="index.php?rotina=2&mod=1&id=0" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Novo Usuário
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablePadrao">
                <thead class="table-dark">
                    <tr>
                        <th width="80">ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo de acesso</th>
                        <th>Ativo?</th>
                        <th width="150">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($usuarios as $u){
                       $classe = $u['ativo'] == "S" ? "" : "table-danger";   
                    ?>
                    <tr class="<?=$classe?>">
                        <td><?= $u['id_usuario'] ?></td>
                        <td><?= $u['nm_usuario'] ?></td>
                        <td><?= $u['nm_email'] ?></td>
                        <td><?= buscaAcesso($u['id_acesso']) ?></td>
                        <td><?= $u['ativo'] == "S" ? "Sim" : "Não" ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="index.php?rotina=2&mod=1&id=<?=$u['id_usuario']?>" class="btn btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if($u['ativo'] == "S"){?>
                                <a href="index.php?rotina=2&mod=3&id=<?=$u['id_usuario']?>&ativo=N" class="btn btn-danger" title="Inativar">
                                    <i class="fa-regular fa-circle-xmark "></i>
                                </a>
                                <?php }else{?>
                                <a href="index.php?rotina=2&mod=3&id=<?=$u['id_usuario']?>&ativo=S" class="btn btn-success" title="Ativar">
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
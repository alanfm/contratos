<div class="page-header">
  <h1><i class="fa fa-user fa-lg" aria-hidden="true"></i> Minha página</h1>
</div>
<div class="row">
    <section class="col-md-6">
        <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?=$_SESSION['alert']['error'];?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> <?php echo $_SESSION['alert']['message']; unset($_SESSION['alert'])?>
        </div>
        <?php endif;?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Meus dados</h3>
            </div>
            <div class="panel-body">            
                <form action="<?=self::link('usuarios/editar/'.$usuario->id.'/perfil')?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="usuario">Nome de Usuário</label>
                        <input type="text" value="<?=$usuario->usuario?>" name="usuario" class="form-control" placeholder="Nome de Usuário" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" value="" name="senha" class="form-control" placeholder="Senha do Usuário">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" value="<?=$usuario->email?>" name="email" class="form-control" placeholder="E-mail do Usuário" required>
                    </div>
                    <?php if (App\Controller\Authentication::is_admin()):?>
                    <div class="form-group">
                        <label for="situacao">Situação</label>
                        <select name="situacao" id="situacao" class="form-control" required>
                            <option value="0"<?=!$usuario->status? ' selected': ''?>>Desativado</option>
                            <option value="1"<?=$usuario->status? ' selected': ''?>>Ativo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nivel">Nível de Acesso</label>
                        <select name="nivel" id="nivel" class="form-control" required>
                            <option value="admin"<?=$usuario->nivel == 'admin'? ' selected': ''?>>Administrado</option>
                            <option value="manager"<?=$usuario->nivel == 'manager'? ' selected': ''?>>Gerente</option>
                            <option value="salesman"<?=$usuario->nivel == 'salesman'? ' selected': ''?>>Vendedor</option>
                        </select>
                    </div>
                    <?php endif;?>
                    <div class="form-group text-center">
                        <button class="btn btn-default btn-lg" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Ultimas Sessões <small class="pull-right">Entradas e saidas do sistema</small></h3>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="row">
                        <th>#</th>
                        <th>Inicio</th>
                        <th>Final</th>
                        <th>Duração</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($sessoes as $tupla):
                        $inicio = new \DateTime($tupla->inicio);
                        $final = new \DateTime($tupla->final);
                    ?>
                    <tr class="row">
                        <td><?=sprintf('%04d', $tupla->id)?></td>
                        <td><?=$inicio->format('d/m/Y H:i:s')?></td>
                        <td><?=$final->format('d/m/Y H:i:s')?></td>
                        <td><?=$inicio->diff($final)->format("%H:%I:%S")?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<div class="page-header">
  <h1><i class="fa fa-plus-square-o fa-lg" aria-hidden="true"></i> Usuários</h1>
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
                <h3 class="panel-title"><?=isset($edit)? "Editar Usuário": "Cadastro de Usuários";?></h3>
            </div>
            <div class="panel-body">            
                <form action="" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="usuario">Nome de Usuário</label>
                        <input type="text" value="<?=$form['usuario']?>" name="usuario" class="form-control" placeholder="Nome de Usuário" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" value="" name="senha" class="form-control" placeholder="Senha do Usuário" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" value="<?=$form['email']?>" name="email" class="form-control" placeholder="E-mail do Usuário" required>
                    </div>
                    <div class="form-group">
                        <label for="situacao">Situação</label>
                        <select name="situacao" id="situacao" class="form-control" required>
                            <option value="ativo"<?=$form['status'] == 'ativo'? ' selected': ''?>>Ativo</option>
                            <option value="desativado"<?=$form['status'] == 'desativado'? ' selected': ''?>>Desativado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nivel">Nível de Acesso</label>
                        <select name="nivel" id="nivel" class="form-control" required>
                            <option value="admin"<?=$form['nivel'] == 'admin'? ' selected': ''?>>Administrado</option>
                            <option value="manager"<?=$form['nivel'] == 'manager'? ' selected': ''?>>Gerente</option>
                            <option value="salesman"<?=$form['nivel'] == 'salesman'? ' selected': ''?>>Vendedor</option>
                        </select>
                    </div>
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
                <h3 class="panel-title">Pesquisar por Usuário</h3>
            </div>
            <div class="panel-body">
                <form action="<?=self::link('usuarios/pesquisar');?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por usuario" required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search fa-lg" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="row">
                        <th class="col-md-1">#</th>
                        <th class="col-md-2">Nome</th>
                        <th class="col-md-2">E-mail</th>
                        <th class="col-md-2">Criado em</th>
                        <th class="col-md-2">Ultimo Acesso</th>
                        <th class="col-md-1">Nível</th>
                        <th class="col-md-2">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nivel = ['admin'=>'Admin', 'manager'=>'Gerente', 'salesman'=>'Vendedor'];
                    foreach($data as $tupla):?>
                    <tr class="row">
                        <td class="col-md-1"><?=$tupla->id?></td>
                        <td class="col-md-2"><?=$tupla->usuario?></td>
                        <td class="col-md-2"><?=$tupla->email?></td>
                        <td class="col-md-2"><?=date("d-m-Y H:i:s", strtotime($tupla->criado_em))?></td>
                        <td class="col-md-2"><?=$tupla->ultimo_acesso? date("d-m-Y H:i:s", strtotime($tupla->ultimo_acesso)): ''?></td>
                        <td class="col-md-1"><?=$nivel[$tupla->nivel]?></td>
                        <td class="col-md-2">                            
                            <div class="btn-group" role="group">
                                <a href="<?=self::link('usuarios/editar/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                <a href="<?=self::link('usuarios/apagar/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php if ($_SESSION['usuarios']['count'] > 1 && empty($_SESSION['usuarios']['search'])):?>
            <nav aria-label="page navigation" class="text-center">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $_SESSION['usuarios']['count']; $i++):?>
                    <li <?=$_SESSION['usuarios']['current_page'] == $i? 'class="active"': ''?>><a href="<?=self::link('usuarios/pagina/'.$i);?>"><?=$i?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif;?>
            <?php if (isset($_SESSION['usuarios']['search'])): unset($_SESSION['usuarios']['search']);?>
                <div class="text-center">
                    <a href="<?=self::link('usuarios');?>" class="btn btn-primary" style="margin-bottom: 2rem;margin-top: 2rem;">Mostrar todos</a>
                </div>
            <?php endif;?>
        </div>
    </section>
</div>
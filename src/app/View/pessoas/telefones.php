<div class="page-header">
  <h1><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Telefones de <small><?=$cliente->nome?></small></h1>
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
                <h3 class="panel-title"><?=isset($edit)? "Editar Telefone": "Cadastro de Telefones";?></h3>
            </div>
            <div class="panel-body">            
                <form action="" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="ddd">DDD</label>
                        <input type="text" value="<?=$form['ddd']?>" name="ddd" maxlength="2" pattern=".{2}" class="form-control" placeholder="99" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" value="<?=$form['numero']?>" name="numero" class="form-control" maxlength="9" pattern=".{8,9}" placeholder="999999999" required><small>Apenas números</small>
                    </div>
                    <div class="form-group">
                        <label for="operadora">Operadora</label>
                        <input type="text" value="<?=$form['operadora']?>" name="operadora" class="form-control" placeholder="Operadora do telefone" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo" class="form-control" required>
                            <option value="celular"<?=$form['tipo'] == 'celular'? ' selected': ''?>>Celular</option>
                            <option value="residencial"<?=$form['tipo'] == 'residencial'? ' selected': ''?>>Residencial</option>
                            <option value="comercial"<?=$form['tipo'] == 'comercial'? ' selected': ''?>>Comercial</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default btn-lg" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                        <?php if (isset($edit)):?>
                            <a href="<?=self::link('clientes/telefones/'.$cliente->id)?>" class="btn btn-default" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i> Cancelar</a>
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Pesquisar por Telefone</h3>
            </div>
            <div class="panel-body">
                <form action="<?=self::link('clientes/telefones/pesquisar/'.$cliente->id);?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por Telefone" required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search fa-lg" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="row">
                        <th>#</th>
                        <th>DDD</th>
                        <th>Número</th>
                        <th>Operadora</th>
                        <th>Tipo</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $tupla):?>
                    <tr class="row">
                        <td><?=$tupla->id?></td>
                        <td><?=$tupla->ddd?></td>
                        <td><?=System\Utilities::mask($tupla->numero, '####-#####')?></td>
                        <td><?=$tupla->operadora?></td>
                        <td><?=$tupla->tipo?></td>
                        <td>                            
                            <div class="btn-group" role="group">
                                <a href="<?=self::link('clientes/telefones/editar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                <a href="<?=self::link('clientes/telefones/apagar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php if ($_SESSION['telefones']['count'] > 1 && empty($_SESSION['telefones']['search'])):?>
            <nav aria-label="page navigation" class="text-center">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $_SESSION['telefones']['count']; $i++):?>
                    <li <?=$_SESSION['telefones']['current_page'] == $i? 'class="active"': ''?>><a href="<?=self::link('clientes/telefones/pagina/'.$cliente->id.'/'.$i);?>"><?=$i?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif;?>
            <?php if (isset($_SESSION['telefones']['search'])): unset($_SESSION['telefones']['search']);?>
                <div class="text-center">
                    <a href="<?=self::link('clientes/telefones/'.$cliente->id);?>" class="btn btn-primary" style="margin-bottom: 2rem;margin-top: 2rem;">Mostrar todos</a>
                </div>
            <?php endif;?>
        </div>
    </section>
</div>
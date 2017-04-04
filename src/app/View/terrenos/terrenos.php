<div class="page-header">
  <h1><i class="fa fa-picture-o fa-lg" aria-hidden="true"></i> Terrenos</h1>
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
                <h3 class="panel-title"><?=isset($edit)? "Editar Terreno": "Cadastro de Terrenos";?></h3>
            </div>
            <div class="panel-body">            
                <form action="" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" value="<?=$form['descricao']?>" name="descricao" class="form-control" placeholder="Descrição do Terreno">
                    </div>
                    <div class="form-group">
                        <label for="descricao">Bairro</label>
                        <input type="text" value="<?=$form['bairro']?>" name="bairro" class="form-control" placeholder="Bairro do Terreno">
                    </div>
                    <div class="form-group">
                        <label for="descricao">Estado</label>
                        <select name="estado" class="form-control" id="estado">
                        <?php foreach($estados as $estado):?>
                            <option value="<?=$estado->id?>"<?=$form['estado'] == $estado->id? ' selected': '';?>>
                                <?=$estado->uf. ' - ' .$estado->nome;?>
                            </option>
                        <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Cidade</label>
                        <select name="cidade" class="form-control" id="cidade">
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
                <h3 class="panel-title">Pesquisar por terrenos</h3>
            </div>
            <div class="panel-body">
                <form action="<?=self::link('terrenos/pesquisar');?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por terrenos" required>
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
                        <th class="col-md-3">Descricção</th>
                        <th class="col-md-3">Bairro</th>
                        <th class="col-md-3">Cidade/UF</th>
                        <th class="col-md-2">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $tupla):?>
                    <tr class="row">
                        <td class="col-md-1"><?=$tupla->id?></td>
                        <td class="col-md-3"><?=$tupla->descricao?></td>
                        <td class="col-md-3"><?=$tupla->bairro?></td>
                        <td class="col-md-3"><?=$tupla->bairro?></td>
                        <td class="col-md-2">                            
                            <div class="btn-group" role="group">
                                <a href="<?=self::link('terrenos/editar/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                <a href="<?=self::link('terrenos/apagar/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php if ($_SESSION['terrenos']['count'] > 1 && empty($_SESSION['terrenos']['search'])):?>
            <nav aria-label="page navigation" class="text-center">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $_SESSION['terrenos']['count']; $i++):?>
                    <li <?=$_SESSION['terrenos']['current_page'] == $i? 'class="active"': ''?>><a href="<?=self::link('terrenos/pagina/'.$i);?>"><?=$i?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif;?>
            <?php if (isset($_SESSION['terrenos']['search'])): unset($_SESSION['terrenos']['search']);?>
                <div class="text-center">
                    <a href="<?=self::link('terrenos');?>" class="btn btn-primary" style="margin-bottom: 2rem;">Mostrar todos</a>
                </div>
            <?php endif;?>
        </div>
    </section>
</div>
<div class="page-header">
  <h1><i class="fa fa-picture-o fa-lg" aria-hidden="true"></i> Lotes</h1>
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
                <h3 class="panel-title"><?=isset($edit)? "Editar Lote": "Cadastro de Lotes";?></h3>
            </div>
            <div class="panel-body">            
                <form action="" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" value="<?=$form['descricao']?>" name="descricao" class="form-control" placeholder="Descrição do Lote" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Comprimento</label>
                        <input type="text" value="<?=$form['comprimento']?>" name="comprimento" class="form-control" placeholder="0,00" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Largura</label>
                        <input type="text" value="<?=$form['largura']?>" name="largura" class="form-control" placeholder="0,00" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Valor</label>
                        <input type="text" value="<?=$form['valor']?>" name="valor" class="form-control" placeholder="R$ 0,00" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Situação</label>
                        <select name="situacao" class="form-control" id="situacao" required>
                            <option value="aberto">Em aberto</option>
                            <option value="vendido">Vendido</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Terreno</label>
                        <select name="terreno" class="form-control" id="terreno" required>
                            <option value="">-- Selecione um Terreno --</option>
                        <?php foreach($terrenos as $terreno):?>
                            <option value="<?=$terreno->id?>"<?=$form['terreno'] == $terreno->id? ' selected': '';?>>
                                <?=$terreno->descricao;?>
                            </option>
                        <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Quadra</label>
                        <select name="quadra" class="form-control" id="quadra" required>
                            <option value="">-- Selecione um Terreno --</option>
                        <?php if (isset($edit)):
                            foreach ($quadras as $quadra):?>
                            <option value="<?=$quadra->id?>"<?=$quadra->id == $form['quadra']? ' selected':''?>><?=$quadra->descricao?></option>
                        <?php endforeach; endif;?>
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
                <h3 class="panel-title">Pesquisar por Lotes</h3>
            </div>
            <div class="panel-body">
                <form action="<?=self::link('lotes/pesquisar');?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por Lotes" required>
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
                        <th class="col-md-2">Descricção</th>
                        <th class="col-md-1">Comp.</th>
                        <th class="col-md-1">Larg.</th>
                        <th class="col-md-1">Valor</th>
                        <th class="col-md-2">Terreno</th>
                        <th class="col-md-1">Quadra</th>
                        <th class="col-md-1">Situação</th>
                        <th class="col-md-2">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $tupla):?>
                    <tr class="row">
                        <td class="col-md-1"><?=$tupla->id?></td>
                        <td class="col-md-2"><?=$tupla->descricao?></td>
                        <td class="col-md-1"><?=$tupla->comprimento?></td>
                        <td class="col-md-1"><?=$tupla->largura?></td>
                        <td class="col-md-1"><?=$tupla->valor?></td>
                        <td class="col-md-2"><?=$tupla->terreno?></td>
                        <td class="col-md-1"><?=$tupla->quadra?></td>
                        <td class="col-md-1"><?=ucfirst($tupla->situacao)?></td>
                        <td class="col-md-2">                            
                            <div class="btn-group" role="group">
                                <a href="<?=self::link('terrenos/lotes/editar/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                <a href="<?=self::link('terrenos/lotes/apagar/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php if ($_SESSION['lotes']['count'] > 1 && empty($_SESSION['lotes']['search'])):?>
            <nav aria-label="page navigation" class="text-center">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $_SESSION['lotes']['count']; $i++):?>
                    <li <?=$_SESSION['lotes']['current_page'] == $i? 'class="active"': ''?>>
                        <a href="<?=self::link('terrenos/lotes/pagina/'.$i);?>"><?=$i?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif;?>
            <?php if (isset($_SESSION['lotes']['search'])): unset($_SESSION['lotes']['search']);?>
                <div class="text-center">
                    <a href="<?=self::link('terrenos/lotes');?>" class="btn btn-primary" style="margin-bottom: 2rem;">Mostrar todos</a>
                </div>
            <?php endif;?>
        </div>
    </section>
</div>
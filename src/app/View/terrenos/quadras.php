<div class="page-header">
  <h1><i class="fa fa-plus-square-o fa-lg" aria-hidden="true"></i> Quadras</h1>
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
                <h3 class="panel-title"><?=isset($edit)? "Editar Quadra": "Cadastro de Quadras";?></h3>
            </div>
            <div class="panel-body">            
                <form action="" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="descricao">Terreno</label>
                        <select name="terreno" class="form-control" autofocus>
                            <?php foreach($terrenos as $terreno):?>
                            <option value="<?=$terreno->id?>"<?=$terreno->id == $form['terreno']? " selected": ""?>>
                                <?=$terreno->descricao;?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" value="<?=$form['descricao']?>" name="descricao" class="form-control" placeholder="Descrição da Quadra">
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default btn-lg" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                        <?php if (isset($edit)):?>
                            <a href="<?=self::link('terrenos/quadras')?>" class="btn btn-default" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i> Cancelar</a>
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Pesquisar por quadras</h3>
            </div>
            <div class="panel-body">
                <form action="<?=self::link('terrenos/quadras/pesquisar');?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por quadras" required>
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
                        <th class="col-md-5">Descricção</th>
                        <th class="col-md-4">Terreno</th>
                        <th class="col-md-2">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $tupla):?>
                    <tr class="row">
                        <td class="col-md-1"><?=$tupla->id?></td>
                        <td class="col-md-5"><?=$tupla->descricao?></td>
                        <td class="col-md-4"><?=$tupla->terreno?></td>
                        <td class="col-md-2">                            
                            <div class="btn-group" role="group">
                                <a href="<?=self::link('terrenos/quadras/editar/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                <a href="<?=self::link('terrenos/quadras/apagar/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php
            if ($_SESSION['quadras']['count'] > 1 && empty($_SESSION['quadras']['search'])):
                $this->template('template/pagination')->data(['current'=>$_SESSION['quadras']['current_page'], 'count'=>$_SESSION['quadras']['count'], 'pagina'=>'terrenos/quadras'])->show();
            endif;?>
            <?php if (isset($_SESSION['quadras']['search'])): unset($_SESSION['quadras']['search']);?>
                <div class="text-center">
                    <a href="<?=self::link('terrenos/quadras');?>" class="btn btn-primary" style="margin-bottom: 2rem;margin-top: 2rem;">Mostrar todos</a>
                </div>
            <?php endif;?>
        </div>
    </section>
</div>
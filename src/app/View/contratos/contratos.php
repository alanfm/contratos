<div class="page-header">
    <a href="<?=self::link('clientes/detalhes/'.$cliente->id)?>" class="btn btn-info btn-lg pull-right"><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Detalhes</a>
    <h1><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Contratos de <small><?=$cliente->nome?></small></h1>
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
                <h3 class="panel-title"><?=isset($edit)? "Editar Contrato": "Cadastro de Contratos";?></h3>
            </div>
            <div class="panel-body">            
                <form action="" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="entrada">Entrada</label>
                        <input type="number" step="any" value="<?=$form['entrada']?>" name="entrada" class="form-control" placeholder="Valor da entrada" <?=isset($edit)? 'disabled':'required autofocus'?>>
                    </div>
                    <div class="form-group">
                        <label for="parcelas">Parcelas</label>
                        <input type="number" value="<?=$form['parcelas']?>" name="parcelas" class="form-control" placeholder="Quantidade de Parcelas" <?=isset($edit)? 'disabled':'required'?>>
                    </div>
                    <div class="form-group">
                        <label for="vencimento">Dia de vencimento</label>
                        <input type="number" value="<?=$form['vencimento']?>" name="vencimento" class="form-control" placeholder="Dia do vencimento das parcelas" <?=isset($edit)? 'autofocus':''?> required>
                    </div>
                    <div class="form-group">
                        <label for="situacao">Situação</label>
                        <select name="status" class="form-control" id="situacao" <?=isset($edit)? 'disabled':'required'?>>
                            <option value="1"<?=$form['status']? ' selected':''?>>Ativo</option>
                            <option value="0"<?=$form['status'] === 0? ' selected':''?>>Cancelado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="terreno">Terreno</label>
                        <select name="terreno" class="form-control" id="terreno" <?=isset($edit)? 'disabled':'required'?>>
                            <option value="">-- Selecione um Terreno --</option>
                        <?php foreach($terrenos as $terreno):?>
                            <option value="<?=$terreno->id?>"<?=$form['terreno'] == $terreno->id? ' selected': '';?>>
                                <?=$terreno->descricao;?>
                            </option>
                        <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quadra">Quadras</label>
                        <select name="quadra" class="form-control" id="quadra" <?=isset($edit)? 'disabled':'required'?>>
                            <option value="">-- Selecione um Terreno --</option>
                        <?php if (isset($edit)):
                            foreach ($quadras as $quadra):?>
                            <option value="<?=$quadra->id?>"<?=$quadra->id == $form['quadra']? ' selected':''?>><?=$quadra->descricao?></option>
                        <?php endforeach; endif;?>
                        </select>
                    </div>                    
                    <div class="form-group">
                        <label for="lote">Lotes</label>
                        <select name="lote" class="form-control" id="lote" data="<?=$form['lote']?>" <?=isset($edit)? 'disabled':'required'?>>
                            <option value="">-- Selecione uma Quadra --</option>
                        <?php if (isset($edit)):?>
                            <option value="<?=$lote->id?>" selected><?=$lote->descricao?></option>
                            <?php foreach ($lotes as $lote):?>
                            <option value="<?=$lote->id?>"<?=$lote->id == $form['lote']? ' selected':''?>><?=$lote->descricao?></option>
                            <?php endforeach;
                        endif;?>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default btn-lg" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                        <?php if (isset($edit)):?>
                            <a href="<?=self::link('contratos/'.$cliente->id)?>" class="btn btn-default" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i> Cancelar</a>
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Pesquisar por Contrato</h3>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="row">
                        <th>#</th>
                        <th>Data</th>
                        <th>Entrada</th>
                        <th>Vencimento</th>
                        <th>Situação</th>
                        <th>Terreno/Quadra/Lote</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $tupla):?>
                    <tr class="row">
                        <td><?=$tupla->id?></td>
                        <td><?=date('d/m/Y', strtotime($tupla->data))?></td>
                        <td><?='R$ ' . number_format($tupla->entrada, 2, ',', '.')?></td>
                        <td><?=$tupla->vencimento?></td>
                        <td><?=$tupla->status? 'Ativo': 'Cancelado'?></td>
                        <td>
                            <?php
                            if ($tupla->status != 2) {
                                echo $tupla->terreno.'/'.$tupla->quadra.'/'.$tupla->lote;
                            }?>
                        </td>
                        <td>
                            <?php if ($tupla->status != 2):?>
                                <div class="btn-group" role="group">
                                    <a href="<?=self::link('contratos/detalhes/'.$tupla->id)?>" class="btn btn-info btn-xs" title="Detalhes"><i class="fa fa-info-circle fa-lg" aria-hidden="true"></i></i></a>
                                    <a href="<?=self::link('contratos/editar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                    <a href="<?=self::link('contratos/apagar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                                </div>
                            <?php endif;?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php if ($_SESSION['contratos']['count'] > 1 && empty($_SESSION['contratos']['search'])):?>
            <nav aria-label="page navigation" class="text-center">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $_SESSION['contratos']['count']; $i++):?>
                    <li <?=$_SESSION['contratos']['current_page'] == $i? 'class="active"': ''?>><a href="<?=self::link('contratos/pagina/'.$cliente->id.'/'.$i);?>"><?=$i?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif;?>
            <?php if (isset($_SESSION['contratos']['search'])): unset($_SESSION['contratos']['search']);?>
                <div class="text-center">
                    <a href="<?=self::link('contratos/'.$cliente->id);?>" class="btn btn-primary" style="margin-bottom: 2rem;margin-top: 2rem;">Mostrar todos</a>
                </div>
            <?php endif;?>
        </div>
    </section>
</div>
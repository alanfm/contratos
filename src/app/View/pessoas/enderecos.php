<div class="page-header">
    <a href="<?=self::link('clientes/detalhes/'.$cliente->id)?>" class="btn btn-info btn-lg pull-right"><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Detalhes</a>
    <h1><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Endereços de <small><?=$cliente->nome?></small></h1>
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
                <h3 class="panel-title"><?=isset($edit)? "Editar Endereço": "Cadastro de Endereços";?></h3>
            </div>
            <div class="panel-body">            
                <form action="" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" value="<?=$form['logradouro']?>" name="logradouro" class="form-control" placeholder="Rua, Sítio, Avenida etc." required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" value="<?=$form['numero']?>" name="numero" class="form-control" placeholder="Número da residência">
                    </div>
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" value="<?=$form['complemento']?>" name="complemento" class="form-control" placeholder="Complemento do endereço">
                    </div>
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" value="<?=$form['bairro']?>" name="bairro" class="form-control" placeholder="Bairro" required>
                    </div>
                    <div class="form-group">
                        <label for="cep">C.E.P.</label>
                        <input type="text" value="<?=$form['cep']?>" name="cep" class="form-control" placeholder="Código de endereçamento postal" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Estado</label>
                        <select name="estado" class="form-control" id="estado" required>
                            <option value="">-- Selecione um Estado --</option>
                        <?php foreach($estados as $estado):?>
                            <option value="<?=$estado->id?>"<?=$form['estado'] == $estado->id? ' selected': '';?>>
                                <?=$estado->uf. ' - ' .$estado->nome;?>
                            </option>
                        <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Cidade</label required>
                        <select name="cidade" class="form-control" id="cidade">
                            <option value="">-- Selecione um Estado --</option>
                        <?php if (isset($edit)):
                            foreach ($cidades as $city):?>
                            <option value="<?=$city->id?>"<?=$city->id == $form['cidade']? ' selected':''?>><?=$city->nome?></option>
                        <?php endforeach; endif;?>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default btn-lg" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                        <?php if (isset($edit)):?>
                            <a href="<?=self::link('clientes/enderecos/'.$cliente->id)?>" class="btn btn-default" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i> Cancelar</a>
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Pesquisar por Endereço</h3>
            </div>
            <div class="panel-body">
                <form action="<?=self::link('clientes/enderecos/pesquisar/'.$cliente->id);?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por Endereço" required>
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
                        <th>Endereço</th>
                        <th>Bairro</th>
                        <th>C.E.P.</th>
                        <th>Cidade/UF</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $tupla):?>
                    <tr class="row">
                        <td><?=$tupla->id?></td>
                        <td><?=$tupla->logradouro . ', '. ($tupla->numero?? 'S/N') . ', ' . ($tupla->complemento?? 'sem complemento')?></td>
                        <td><?=$tupla->bairro?></td>
                        <td><?=$tupla->cep?></td>
                        <td><?=$tupla->cidade . '/' . $tupla->estado?></td>
                        <td>                            
                            <div class="btn-group" role="group">
                                <a href="<?=self::link('clientes/enderecos/editar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                <a href="<?=self::link('clientes/enderecos/apagar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php
            if ($_SESSION['enderecos']['count'] > 1 && empty($_SESSION['enderecos']['search'])):
                $this->template('template/pagination')->data(['current'=>$_SESSION['enderecos']['current_page'], 'count'=>$_SESSION['enderecos']['count'], 'pagina'=>'clientes/enderecos'])->show();
            endif;?>
            <?php if (isset($_SESSION['enderecos']['search'])): unset($_SESSION['enderecos']['search']);?>
                <div class="text-center">
                    <a href="<?=self::link('clientes/enderecos/'.$cliente->id);?>" class="btn btn-primary" style="margin-bottom: 2rem;margin-top: 2rem;">Mostrar todos</a>
                </div>
            <?php endif;?>
        </div>
    </section>
</div>
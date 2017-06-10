<div class="page-header">
  <h1><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Clientes</h1>
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
                <h3 class="panel-title"><?=isset($edit)? "Editar Cliente": "Cadastro de Clientes";?></h3>
            </div>
            <div class="panel-body">            
                <form action="" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="nome">Nome de Cliente</label>
                        <input type="text" value="<?=$form['nome']?>" name="nome" class="form-control" placeholder="Nome do Cliente" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="text" value="<?=$form['data_nascimento']?>" name="data_nascimento" class="form-control date" placeholder="dd/mm/aaaa" required>
                    </div>
                    <div class="form-group">
                        <label for="cpf">C.P.F.</label>
                        <input type="text" value="<?=$form['cpf']?>" name="cpf" class="form-control" maxlength="11" pattern=".{11,11}" placeholder="C.P.F. do Cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="rg">R.G.</label>
                        <input type="text" value="<?=$form['rg']?>" name="rg" class="form-control"  maxlength="15" pattern=".{4,15}" placeholder="R.G. do Cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="rg_emissao">Data de Emissão</label>
                        <input type="text" value="<?=$form['rg_emissao']?>" name="rg_emissao" class="form-control date" placeholder="dd/mm/aaaa" required>
                    </div>
                    <div class="form-group">
                        <label for="rg_org_expedidor">Orgão Expedidor do R.G.</label>
                        <input type="text" value="<?=$form['rg_org_expedidor']?>" name="rg_org_expedidor" class="form-control" placeholder="Orgão Expedidor do R.G." required>
                    </div>
                    <div class="form-group">
                        <label for="estado_civil">Estado Civil</label>
                        <select name="estado_civil" id="estado_civil" class="form-control" required>
                            <option value="solteiro"<?=$form['estado_civil'] == 'solteiro'? ' selected': ''?>>Solteiro (a)</option>
                            <option value="casado"<?=$form['estado_civil'] == 'casado'? ' selected': ''?>>Casado (a)</option>
                            <option value="divorciado"<?=$form['estado_civil'] == 'divorciado'? ' selected': ''?>>Divorciado (a)</option>
                            <option value="viuvo"<?=$form['estado_civil'] == 'viuvo'? ' selected': ''?>>Viuvo (a)</option>
                            <option value="separado"<?=$form['estado_civil'] == 'separado'? ' selected': ''?>>Separado (a)</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default btn-lg" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                        <?php if (isset($edit)):?>
                            <a href="<?=self::link('clientes')?>" class="btn btn-default" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i> Cancelar</a>
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Pesquisar por Cliente</h3>
            </div>
            <div class="panel-body">
                <form action="<?=self::link('clientes/pesquisar');?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar por Cliente" required>
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
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>C.P.F.</th>
                        <th>R.G.</th>
                        <th>Estado Civil</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $tupla):?>
                    <tr class="row">
                        <td><?=$tupla->id?></td>
                        <td><?=$tupla->nome?></td>
                        <td><?=date("d/m/Y", strtotime($tupla->data_nascimento))?></td>
                        <td><?=System\Utilities::mask($tupla->cpf, '###.###.###-##')?></td>
                        <td><?=$tupla->rg?></td>
                        <td><?=ucfirst($tupla->estado_civil)?>(a)</td>
                        <td>                            
                            <div class="btn-group" role="group">
                                <a href="<?=self::link('clientes/detalhes/'.$tupla->id)?>" class="btn btn-info btn-xs" title="Detalhes"><i class="fa fa-info-circle fa-lg" aria-hidden="true"></i></i></a>
                                <a href="<?=self::link('clientes/editar/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                <?php if (!App\Storage\Contratos::count(['conditions'=>['pessoas_id = ?', $tupla->id]])):?>
                                    <a href="<?=self::link('clientes/apagar/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                                <?php endif;?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php
            if ($_SESSION['clientes']['count'] > 1 && empty($_SESSION['clientes']['search'])):
                $this->template('template/pagination')->data(['current'=>$_SESSION['clientes']['current_page'], 'count'=>$_SESSION['clientes']['count'], 'pagina'=>'clientes'])->show();
            endif;?>
            <?php if (isset($_SESSION['clientes']['search'])): unset($_SESSION['clientes']['search']);?>
                <div class="text-center">
                    <a href="<?=self::link('clientes');?>" class="btn btn-primary" style="margin-bottom: 2rem;margin-top: 2rem;">Mostrar todos</a>
                </div>
            <?php endif;?>
        </div>
    </section>
</div>
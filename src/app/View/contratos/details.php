<div class="page-header">
    <a href="<?=self::link('clientes/detalhes/'.$cliente->id)?>" class="btn btn-info btn-lg pull-right"><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Detalhes</a>
    <h1><i class="fa fa-file-text-o fa-lg" aria-hidden="true"></i> Contrato de <small><?=$cliente->nome?></small></h1>
</div>
<div class="row">
    <section class="col-md-12">        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Contrato</h3>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Entrada</th>
                        <th>Parcelas</th>
                        <th>Pagas</th>
                        <th>Vencimento</th>
                        <th>Situação</th>
                        <th>Terreno/Quadra/Lote</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$contrato->id?></td>
                        <td><?=date('d/m/Y', strtotime($contrato->data))?></td>
                        <td><?='R$ ' . number_format($contrato->entrada, 2, ',', '.')?></td>
                        <td><?=$contrato->parcelas?></td>
                        <td><?=$parcelas_pagas?></td>
                        <td><?=$contrato->vencimento?></td>
                        <td><?=$contrato->status? 'Ativo': 'Cancelado'?></td>
                        <td><?=$contrato->terreno.'/'.$contrato->quadra.'/'.$contrato->lote?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <section class="col-md-4">
        <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?=$_SESSION['alert']['error'];?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> <?php echo $_SESSION['alert']['message']; unset($_SESSION['alert'])?>
        </div>
        <?php endif;?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Opções de contrato</h3>
            </div>
            <div class="panel-body">            
                <a href="#" class="btn btn-info btn-block">Visualizar Contrato</a>
                <a href="<?=self::link('parcelas/carne/'.$contrato->id)?>" class="btn btn-success btn-block" target="_blank">Visualizar Carnê de Pagamento</a>
                <a href="#" class="btn btn-danger btn-block">Cancelar Contrato</a>
            </div>
        </div>
    </section>    
    <section class="col-md-8">
        <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?=$_SESSION['alert']['error'];?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> <?php echo $_SESSION['alert']['message']; unset($_SESSION['alert'])?>
        </div>
        <?php endif;?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Prestações</h3>
            </div>
            <table class="table table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Data de vencimento</th>
                        <th>Valor</th>
                        <th>Data de pagamento</th>
                        <th>Valor Recebido</th>
                        <th>Documento</th>
                        <th>Situação</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($parcelas as $tupla):?>
                    <tr>
                        <td><?=$tupla->id?></td>
                        <td><?=$tupla->descricao?></td>
                        <td><?=date('d/m/Y', strtotime($tupla->vencimento))?></td>
                        <td><?='R$ ' . number_format($tupla->valor, 2, ',', '.')?></td>
                        <td><?=!is_null($tupla->quitada)? date('d/m/Y', strtotime($tupla->quitada)): '-'?></td>
                        <td><?='R$ ' . ($tupla->recebido? date('d/m/Y', strtotime($tupla->recebido)):'0,00')?></td>
                        <td><?=$tupla->documento?? '-'?></td>
                        <td><?=$tupla->status? 'Quitada':'Em aberto'?></td>
                        <td>                            
                            <div class="btn-group" role="group">
                                <a href="#" class="btn btn-success btn-xs" title="Editar" data-toggle="modal" data-target="#pay"><i class="fa fa-money fa-lg" aria-hidden="true"></i></i></a>
                                <a href="<?=self::link('contratos/parcelas/editar/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                <a href="<?=self::link('contratos/parcelas/cancelar/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<!-- Modal -->
<div class="modal fade" id="pay" tabindex="-1" role="dialog" aria-labelledby="myPay">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="quitada">Data</label>
                        <input type="text" step="any" name="quitada" class="form-control date" placeholder="Data da entrada" required>
                    </div>
                    <div class="form-group">
                        <label for="recebido">Valor recebido</label>
                        <input type="number" step="any" name="recebido" class="form-control" placeholder="Valor da parcela" required>
                    </div>
                    <div class="form-group">
                        <label for="documento">Número documento</label>
                        <input type="number" step="any" name="documento" class="form-control" placeholder="Número da documento" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
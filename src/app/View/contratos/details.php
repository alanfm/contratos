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
                        <th>Total Pago</th>
                        <th>Vencimento</th>
                        <th>Situação</th>
                        <th>Terreno/Quadra/Lote</th>
                        <th>Valor do Lote</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$contrato->id?></td>
                        <td><?=date('d/m/Y', strtotime($contrato->data))?></td>
                        <td><?='R$ ' . number_format($contrato->entrada, 2, ',', '.')?></td>
                        <td><?=$contrato->parcelas?></td>
                        <td><?=$parcelas_pagas?></td>
                        <td><?='R$ ' . number_format($valor_recebido, 2, ',', '.')?></td>
                        <td><?=$contrato->vencimento?></td>
                        <td><?=$contrato->status? 'Ativo': 'Cancelado'?></td>
                        <td><?=$contrato->terreno.'/'.$contrato->quadra.'/'.$contrato->lote?></td>
                        <td><?='R$ ' . number_format($contrato->valor, 2, ',', '.')?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <section class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Opções de contrato</h3>
            </div>
            <div class="panel-body">            
                <a href="<?=self::link('contratos/imprimir/'.$contrato->id)?>" class="btn btn-info btn-block" target="_blank"><i class="fa fa-file-text-o fa-lg" aria-hidden="true"></i> Visualizar Contrato</a>
                <a href="<?=self::link('parcelas/carne/'.$contrato->id)?>" class="btn btn-success btn-block" target="_blank"><i class="fa fa-credit-card fa-lg" aria-hidden="true"></i> Visualizar Carnê de Pagamento</a>
                <?php if(App\Controller\Authentication::is_manager()):?>
                    <a href="<?=self::link('contratos/cancelar/'.$cliente->id.'/'.$contrato->id.'/contratos')?>" class="btn btn-danger btn-block"><i class="fa fa-ban fa-lg" aria-hidden="true"></i> Cancelar Contrato</a>
                <?php endif;?>
            </div>
        </div>
    </section>    
    <section class="col-md-9">
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
                        <th>Multa</th>
                        <th>Juros</th>
                        <th>Documento</th>
                        <th>Situação</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $status = ['Em aberto', 'Quitada', 'Cancelada'];
                    $class = ['', 'success', 'danger text-muted'];
                    foreach ($parcelas as $tupla):?>
                    <tr class="<?=$class[$tupla->status]?>">
                        <td><?=$tupla->id?></td>
                        <td><?=$tupla->descricao?></td>
                        <td><?=date('d/m/Y', strtotime($tupla->vencimento))?></td>
                        <td><?='R$ ' . number_format($tupla->valor, 2, ',', '.')?></td>
                        <td><?=!is_null($tupla->quitada)? date('d/m/Y', strtotime($tupla->quitada)): '-'?></td>
                        <td><?='R$ ' . ($tupla->recebido? number_format($tupla->recebido, 2, ',', '.'):'0,00')?></td>
                        <td><?='R$ ' . ($tupla->multa? number_format($tupla->multa, 2, ',', '.'):'0,00')?></td>
                        <td><?='R$ ' . ($tupla->juros? number_format($tupla->juros, 2, ',', '.'):'0,00')?></td>
                        <td><?=$tupla->documento?? '-'?></td>
                        <td><?=$status[$tupla->status]?></td>
                        <td>                            
                            <div class="btn-group" role="group">
                                <?php if ($tupla->status == 0):?>
                                    <a href="#" class="btn btn-success btn-xs payment" title="Pagamento" data-toggle="modal" data-target="#pay" data-parcela="<?=$tupla->id?>" data-descricao="<?=$tupla->descricao?>"><i class="fa fa-money fa-lg" aria-hidden="true"></i></i></a>
                                <?php endif;?>                                 
                                <a href="<?=self::link('parcelas/editar/'.$tupla->id)?>" class="btn btn-warning btn-xs payment" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                <?php if ($tupla->status == 0):?>
                                    <a href="<?=self::link('parcelas/cancelar/'.$tupla->id.'/'.System\Utilities::token())?>" class="btn btn-danger btn-xs cancel" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i></a>
                                <?php endif;?>
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
                <h4 class="modal-title" id="myModalLabel">Recebimento de Prestação</h4>
            </div>
            <form action="<?=self::link('/parcelas/pagamento')?>" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="parcela">Número</label>
                        <input type="text" name="parcela_show" value="" class="form-control payment-input" disabled>
                        <input type="hidden" name="parcela" value="" class="form-control payment-input">
                    </div>
                    <div class="form-group">
                        <label for="parcela">Parcela</label>
                        <input type="text" name="descricao_show" value="" class="form-control description-input" disabled>
                    </div>
                    <div class="form-group">
                        <label for="quitada">Data</label>
                        <input type="text" step="any" name="quitada" class="form-control date" placeholder="Data da entrada" required>
                    </div>
                    <div class="form-group">
                        <label for="recebido">Valor da Parcela</label>
                        <input type="number" step="any" name="recebido" class="form-control" placeholder="Valor da parcela" required>
                    </div>                    
                    <div class="form-group">
                        <label for="multa">Multa</label>
                        <input type="number" step="any" name="multa" class="form-control" placeholder="Valor da multa">
                    </div>
                    <div class="form-group">
                        <label for="juros">Juros</label>
                        <input type="number" step="any" name="juros" class="form-control" placeholder="Valor dos juros">
                    </div>
                    <div class="form-group">
                        <label for="documento">Número documento</label>
                        <input type="text" name="documento" class="form-control" placeholder="Número da documento" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="page-header">
    <h1>
        <i class="fa fa-bar-chart fa-lg" aria-hidden="true"></i> Relatórios <small>Parcelas</small>

        <!-- Single button -->
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mais Relatórios <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?=self::link('relatorios/parcelas')?>">Principal</a></li>
                <li><a href="<?=self::link('relatorios/parcelas/data')?>">Por Data</a></li>
            </ul>
        </div>
    </h1>
</div>
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Parcelas ativas <small class="pull-right">Total</small></h3></div>
        <table class="table table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th>Total</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$total_abertas->total?></td>
                    <td>R$ <?=number_format($total_abertas->valor, 2, ',', '.')?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Parcelas em atrazo <small class="pull-right">Total</small></h3></div>
        <table class="table table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th>Total</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$total_atrasadas->total?></td>
                    <td>R$ <?=number_format($total_atrasadas->valor, 2, ',', '.')?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Parcelas canceladas <small class="pull-right">Total</small></h3></div>
        <table class="table table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th>Total</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$total_canceladas->total?></td>
                    <td>R$ <?=number_format($total_canceladas->valor, 2, ',', '.')?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Parcelas Pagas <small class="pull-right">Total</small></h3></div>
        <table class="table table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th>Total</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$total_pagas->total?></td>
                    <td>R$ <?=number_format($total_pagas->valor, 2, ',', '.')?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="col-md-12">
            <p>Valores abaixo são referentes a 01/<?=date('m')?> a <?=date('t/m')?>.</p>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Parcelas a vencer <small class="pull-right">Mês atual</small></h3></div>
                <table class="table table-condensed table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Total</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$a_vencer->total?></td>
                            <td>R$ <?=number_format($a_vencer->valor, 2, ',', '.')?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Parcelas recebidas <small class="pull-right">Mês atual</small></h3></div>
                <table class="table table-condensed table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Total</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$recebidas->total?></td>
                            <td>R$ <?=number_format($recebidas->valor, 2, ',', '.')?></td>
                        </tr>
                    </tbody>
                </table>
            </div>    
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Clientes com parcelas atrasadas <small class="pull-right">Total</small></h3></div>
                <table class="table table-condensed table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data</th>
                            <th>Terreno/Quadra/Lote</th>
                            <th>Contrato</th>
                            <th>Parcela</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($atrasadas as $atrasada):?>
                            <tr>
                                <td><?=$atrasada->cliente?></td>
                                <td><?=date('d/m/Y', strtotime($atrasada->vencimento))?></td>
                                <td><?=sprintf('%s/%s/%s', $atrasada->terreno, $atrasada->quadra, $atrasada->lote)?></td>
                                <td><?=$atrasada->contrato?></td>
                                <td><?=$atrasada->parcela?></td>
                                <td>R$ <?=number_format($atrasada->valor, 2, ',', '.')?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
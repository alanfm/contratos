<div class="page-header">
    <h1>
        <i class="fa fa-bar-chart fa-lg" aria-hidden="true"></i> Relatórios <small>Contratos</small>

        <!-- Single button -->
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mais Relatórios <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?=self::link('relatorios/contratos')?>">Principal</a></li>
            </ul>
        </div>
    </h1>
</div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Contratos Ativos <small class="pull-right">Total</small></h3></div>
        <table class="table table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th>Total</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$ativos->total?></td>
                    <td>R$ <?=number_format($ativos->valor, 2, ',', '.')?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Contratos Quitados <small class="pull-right">Total</small></h3></div>
        <table class="table table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th>Total</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$quitados->total?></td>
                    <td>R$ <?=number_format($quitados->valor, 2, ',', '.')?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Contratos Cancelados <small class="pull-right">Total</small></h3></div>
        <table class="table table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th>Total</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$cancelados->total?></td>
                    <td>R$ <?=number_format($cancelados->valor, 2, ',', '.')?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

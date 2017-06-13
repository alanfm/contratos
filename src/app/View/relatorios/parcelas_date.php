<div class="page-header">
    <h1><i class="fa fa-bar-chart fa-lg" aria-hidden="true"></i> Relatórios <small>Parcelas</small></h1>
</div>
<div class="row">
    <form role="form" method="post">
        <div class="col-md-2 col-md-offset-2">
            <div class="form-group">
                <label for="date_init">Data inicial: </label>
                <input type="text" name="date_init" class="form-control date" id="date_init" placeholder="dd/mm/aaaa" required autofocus>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="date_end">Data final: </label>
                <input type="text" name="date_end" class="form-control date" id="date_end" placeholder="dd/mm/aaaa" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="situacao">Situação: </label>
                <select name="situacao" id="situacao" class="form-control">
                    <option value="0">Em aberto</option>
                    <option value="1">Quitada</option>
                    <option value="2">Cancelada</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-default" style="margin-top: 2.4rem">Buscar</button>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-md-12">
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?=$_SESSION['alert']['error'];?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Aviso!</strong> <?php echo $_SESSION['alert']['message']; unset($_SESSION['alert'])?>
            </div>
        <?php endif;?>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Parcela</th>
                    <th>Cliente</th>
                    <th>Vencimento</th>
                    <th>Valor</th>
                    <th>Multa</th>
                    <th>Juros</th>
                    <th>Situação</th>
                    <th>Contrato</th>
                    <th>Terreno/Quadra/Lote</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $situacao = ['Em aberto', 'Quitada', 'Cancelada'];
                foreach ($data as $tupla):?>
                    <tr>
                        <td><?=sprintf('%04d', $tupla->parcela)?></td>
                        <td><?=$tupla->cliente?></td>
                        <td><?=date('d/m/Y', strtotime($tupla->vencimento))?></td>
                        <td>R$ <?=number_format($tupla->valor, 2, ',', '.')?></td>
                        <td>R$ <?=number_format($tupla->multa, 2, ',', '.')?></td>
                        <td>R$ <?=number_format($tupla->juros, 2, ',', '.')?></td>
                        <td><?=$situacao[$tupla->status]?></td>
                        <td><?=sprintf('%04d', $tupla->contrato)?></td>
                        <td><?=sprintf('%s/%s/%s', $tupla->terreno, $tupla->quadra, $tupla->lote)?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
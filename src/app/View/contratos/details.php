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
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Entrada</th>
                        <th>Parcelas</th>
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
                <a href="" class="btn btn-info btn-block">Visualizar Constrato</a>
                <a href="" class="btn btn-primary btn-block">Gerar Parcelas</a>
                <a href="" class="btn btn-success btn-block">Visualizar Carnê de Pagamento</a>
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
            <div class="panel-body">            
                
            </div>
        </div>
    </section>
</div>
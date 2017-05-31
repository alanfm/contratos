<div class="page-header">
  <h1><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Parcelas</h1>
</div>
<div class="row">
    <section class="col-md-offset-3 col-md-6">
        <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?=$_SESSION['alert']['error'];?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> <?php echo $_SESSION['alert']['message']; unset($_SESSION['alert'])?>
        </div>
        <?php endif;?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Editar Parcela</h3>
            </div>
            <div class="panel-body">            
                <form action="<?=self::link('parcelas/editar/'.$parcela->id)?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" value="<?=$parcela->descricao?>" name="descricao" class="form-control" placeholder="Descrição" disabled>
                    </div>
                    <div class="form-group">
                        <label for="vencimento">Vencimento</label>
                        <input type="text" value="<?=date('d/m/Y', strtotime($parcela->vencimento))?>" name="vencimento" class="form-control" placeholder="Vencimento" disabled>
                    </div>
                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input type="text" value="<?=$parcela->valor?>" name="valor" class="form-control" placeholder="Valor" disabled>
                    </div>
                    <div class="form-group">
                        <label for="pagamento">Data do pagamento</label>
                        <input type="text" value="<?=$parcela->quitada? date('d/m/Y', strtotime($parcela->quitada)):''?>" name="quitada" class="form-control" placeholder="Data do pagamento">
                    </div>
                    <div class="form-group">
                        <label for="recebido">Valor recebido</label>
                        <input type="number" step="any" value="<?=$parcela->recebido?>" name="recebido" class="form-control" placeholder="Valor recebido">
                    </div>
                    <div class="form-group">
                        <label for="multa">Valor da multa</label>
                        <input type="number" step="any" value="<?=$parcela->multa?>" name="multa" class="form-control" placeholder="Valor da multa">
                    </div>
                    <div class="form-group">
                        <label for="juros">Valor dos juros</label>
                        <input type="number" step="any" value="<?=$parcela->juros?>" name="juros" class="form-control" placeholder="Valor dos juros">
                    </div>
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <input type="text" value="<?=$parcela->documento?>" name="documento" class="form-control" placeholder="Documento">
                    </div>
                    <div class="form-group">
                        <label for="status">Situação</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="0"<?=$parcela->status == 0? ' selected': ''?>>Em aberto</option>
                            <option value="1"<?=$parcela->status == 1? ' selected': ''?>>Quitada</option>
                            <option value="2"<?=$parcela->status == 2? ' selected': ''?>>Cancelada</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default btn-lg" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                        <a href="<?=self::link('contratos/detalhes/'.$parcela->contratos_id)?>" class="btn btn-default" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="col-md-6">

    </section>
</div>
<div class="page-header">
  <h1><i class="fa fa-cog fa-lg" aria-hidden="true"></i> Configurações</h1>
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
                <h3 class="panel-title">Dados do Vendedor</h3>
            </div>
            <div class="panel-body">            
                <form action="" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <input type="hidden" value="<?=$create_vendedor?>" name="create">
                    <div class="form-group">
                        <label for="nome">Nome do Vendedor</label>
                        <input type="text" value="<?=$form['nome']?>" name="nome" class="form-control" placeholder="Nome do Vendedor" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail do Vendedor</label>
                        <input type="text" value="<?=$form['email']?>" name="email" class="form-control" placeholder="E-mail do Vendedor" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="text" value="<?=$form['data_nascimento']?>" name="data_nascimento" class="form-control date" placeholder="dd/mm/aaaa" required>
                    </div>
                    <div class="form-group">
                        <label for="cpf">C.P.F.</label>
                        <input type="text" value="<?=$form['cpf']?>" name="cpf" class="form-control" maxlength="11" pattern=".{11,11}" placeholder="C.P.F. do Vendedor" required>
                    </div>
                    <div class="form-group">
                        <label for="rg">R.G.</label>
                        <input type="text" value="<?=$form['rg']?>" name="rg" class="form-control"  maxlength="15" pattern=".{4,15}" placeholder="R.G. do Vendedor" required>
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
                            <option value="solteiro"<?=$form['estado_civil'] == 'solteiro'? ' selected': ''?>>Solteiro</option>
                            <option value="casado"<?=$form['estado_civil'] == 'casado'? ' selected': ''?>>Casado</option>
                            <option value="divorciado"<?=$form['estado_civil'] == 'divorciado'? ' selected': ''?>>Divorciado</option>
                            <option value="viuvo"<?=$form['estado_civil'] == 'viuvo'? ' selected': ''?>>Viuvo</option>
                            <option value="separado"<?=$form['estado_civil'] == 'separado'? ' selected': ''?>>Separado</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dados da Empresa</h3>
            </div>
            <div class="panel-body">
                <form action="<?=self::link('configuracoes/empresa')?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <input type="hidden" value="<?=$create_empresa?>" name="create">
                    <div class="form-group">
                        <label for="nome">Empresa</label>
                        <input type="text" value="<?=$form['empresa']?>" name="nome" class="form-control" placeholder="Nome da Empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="cnpj">C.N.P.J.</label>
                        <input type="text" value="<?=$form['cnpj']?>" name="cnpj" class="form-control cnpj" placeholder="Cadastro Nacional de Pessoa Jurídica">
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dados da Conta</h3>
            </div>
            <div class="panel-body">
                <form action="<?=self::link('configuracoes/conta')?>" method="post">
                    <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                    <input type="hidden" value="<?=$create_conta?>" name="create">
                    <div class="form-group">
                        <label for="banco">Banco</label>
                        <input type="text" value="<?=$form['banco']?>" name="banco" class="form-control" placeholder="Banco" required>
                    </div>
                    <div class="form-group">
                        <label for="agencia">Agência</label>
                        <input type="text" value="<?=$form['agencia']?>" name="agencia" class="form-control" placeholder="Agência" required>
                    </div>
                    <div class="form-group">
                        <label for="conta">Conta</label>
                        <input type="text" value="<?=$form['conta']?>" name="conta" class="form-control" placeholder="Conta" required>
                    </div>
                    <div class="form-group">
                        <label for="operacao">Operação</label>
                        <input type="text" value="<?=$form['operacao']?>" name="operacao" class="form-control" placeholder="Operação">
                    </div>
                    <div class="form-group">
                        <label for="multa">Multa</label>
                        <input type="number" step="any" value="<?=$form['multa']?>" name="multa" class="form-control" placeholder="Multa" required>
                    </div>
                    <div class="form-group">
                        <label for="juros">Juros</label>
                        <input type="number" step="any" value="<?=$form['juros']?>" name="juros" class="form-control" placeholder="Juros" required>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-default" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
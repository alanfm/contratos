<div class="page-header">
    <h1>
        <i class="fa fa-users fa-lg" aria-hidden="true"></i> Relatórios <small>Usuários</small>

        <!-- Single button -->
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mais Relatórios <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?=self::link('relatorios/usuarios')?>">Usuarios</a></li>
            </ul>
        </div>
    </h1>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Usuários</div>
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=sprintf('%04d',$total)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Admistrador<small class="pull-right">Total</small></h3></div>
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=sprintf('%04d',$total_admin)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Gerente<small class="pull-right">Total</small></h3></div>
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=sprintf('%04d',$total_manager)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Vendedor<small class="pull-right">Total</small></h3></div>
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=sprintf('%04d',$total_salesman)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Usuários<small class="pull-right">Total</small></h3></div>
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>E-mail</th>
                        <th>Data da ultima sessão</th>
                        <th>Quantidade de sessões</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $tupla):?>
                        <tr>
                            <td><?=$tupla->usuario?></td>
                            <td><?=$tupla->email?></td>
                            <td><?=(new \DateTime($tupla->ultimo_acesso))->format('d/m/Y H:i:s')?></td>
                            <td><?=sprintf('%04d', App\Storage\Sessoes::count(['conditions'=>['usuarios_id = ?', $tupla->id]]))?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>    
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Tempo on-line<small class="pull-right">Total</small></h3></div>
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>E-mail</th>
                        <th>Tempo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sessoes as $tupla):?>
                        <tr>
                            <td><?=$tupla->usuario?></td>
                            <td><?=$tupla->email?></td>
                            <td><?=$tupla->all_time?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
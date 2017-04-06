<div class="page-header">
  <h1><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Detalhes <small><?=$cliente->nome?></small></h1>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dados Pessoais</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <h4 class="list-group-item-heading">Nome</h4>
                    <p class="list-group-item-text"><?=$cliente->nome?></p>
                </li>
                <li class="list-group-item">
                    <h4 class="list-group-item-heading">Data de Nascimento</h4>
                    <p class="list-group-item-text"><?=date('d/m/Y', strtotime($cliente->data_nascimento))?></p>
                </li>
                <li class="list-group-item">
                    <h4 class="list-group-item-heading">C.P.F.</h4>
                    <p class="list-group-item-text"><?=System\Utilities::mask($cliente->cpf, '###.###.###-##')?></p>
                </li>
                <li class="list-group-item">
                    <h4 class="list-group-item-heading">R.G.</h4>
                    <p class="list-group-item-text"><?=$cliente->rg?></p>
                </li>
                <li class="list-group-item">
                    <h4 class="list-group-item-heading">Data de Emissão</h4>
                    <p class="list-group-item-text"><?=date('d/m/Y', strtotime($cliente->rg_emissao))?></p>
                </li>
                <li class="list-group-item">
                    <h4 class="list-group-item-heading">Orgão Emissor</h4>
                    <p class="list-group-item-text"><?=$cliente->rg_org_expedidor?></p>
                </li>
                <li class="list-group-item">
                    <h4 class="list-group-item-heading">Estado Civil</h4>
                    <p class="list-group-item-text"><?=ucfirst($cliente->estado_civil)?></p>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Endereços</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Telefones</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Contratos</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
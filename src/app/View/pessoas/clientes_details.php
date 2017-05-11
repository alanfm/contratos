<div class="page-header">
  <h1><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Detalhes <small><?=$cliente->nome?></small></h1>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?=self::link('clientes/editar/'.$cliente->id)?>" class="btn btn-warning btn-xs pull-right" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
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
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="<?=self::link('clientes/enderecos/'.$cliente->id)?>" class="btn btn-default btn-xs pull-right" title="Novo"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
                        <h3 class="panel-title">Endereços</h3>
                    </div>
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Endereço</th>
                                <th>Bairro</th>
                                <th>C.E.P.</th>
                                <th>Cidade/UF</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($enderecos as $endereco):?>
                                <tr>
                                    <td><?=$endereco->id?></td>
                                    <td><?=$endereco->logradouro . ', ' . ($endereco->numero?? 'S/N') . ', ' . ($endereco->complemento?? 'sem complemento')?></td>
                                    <td><?=$endereco->bairro?></td>
                                    <td><?=$endereco->cep?></td>
                                    <td><?=$endereco->cidade.'/'.$endereco->estado?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?=self::link('clientes/enderecos/editar/'.$cliente->id.'/'.$endereco->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                            <a href="<?=self::link('clientes/enderecos/apagar/'.$cliente->id.'/'.$endereco->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="<?=self::link('clientes/telefones/'.$cliente->id)?>" class="btn btn-default btn-xs pull-right" title="Novo"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
                        <h3 class="panel-title">Telefones</h3>
                    </div>
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>DDD</th>
                                <th>Telefone</th>
                                <th>Operadora</th>
                                <th>Tipo</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($telefones as $tupla):?>
                            <tr>
                                <td><?=$tupla->id?></td>
                                <td><?=$tupla->ddd?></td>
                                <td><?=$tupla->numero?></td>
                                <td><?=$tupla->operadora?></td>
                                <td><?=ucfirst($tupla->tipo)?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?=self::link('clientes/telefones/editar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                        <a href="<?=self::link('clientes/telefones/apagar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                                    </div>                                    
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <small>Para criar um contrato cadastre um Endereço e um Telefone</small>
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <?php if (count($telefones) && count($enderecos)):?>
                        <a href="<?=self::link('contratos/'.$cliente->id)?>" class="btn btn-primary btn-xs pull-right" title="Novo"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
                    <?php endif;?>
                        <h3 class="panel-title">Contratos</h3>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="row">
                                <th>#</th>
                                <th>Data</th>
                                <th>Entrada</th>
                                <th>Vencimento</th>
                                <th>Situação</th>
                                <th>Terreno/Quadra/Lote</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($contratos as $tupla):?>
                            <tr class="row">
                                <td><?=$tupla->id?></td>
                                <td><?=date('d/m/Y', strtotime($tupla->data))?></td>
                                <td><?='R$ ' . number_format($tupla->entrada, 2, ',', '.')?></td>
                                <td><?=$tupla->vencimento?></td>
                                <td><?=$tupla->status? 'Ativo': 'Cancelado'?></td>
                                <td><?=$tupla->terreno.'/'.$tupla->quadra.'/'.$tupla->lote?></td>
                                <td>                            
                                    <div class="btn-group" role="group">
                                        <a href="<?=self::link('contratos/detalhes/'.$tupla->id)?>" class="btn btn-info btn-xs" title="Detalhes"><i class="fa fa-info-circle fa-lg" aria-hidden="true"></i></i></a>
                                        <a href="<?=self::link('contratos/editar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                                        <a href="<?=self::link('contratos/cancelar/'.$cliente->id.'/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
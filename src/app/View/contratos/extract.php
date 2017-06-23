<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <base href="<?=URL_BASE?>">
        <meta charset="UTF-8">
        <title>Extrato do Contrato de <?=$cliente->nome?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="public/css/bootstrap.min.css">
        <style>
            body {
                font-family: monospace;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <h1><?=$empresa->nome?><br><small><?=$lote->terreno?></small></h1>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-condensed">
                        <tbody>
                            <tr>
                                <td colspan="2"><small>Nome do Cliente</small><br><?=$cliente->nome?></td>
                                <td><small>Data de Nascimento</small><br><?=date('d/m/Y', strtotime($cliente->data_nascimento))?></td>
                            </tr>
                            <tr>
                                <td class="col-md-4"><small>CPF</small><br><?=System\Utilities::mask($cliente->cpf, '###.###.###-##')?></td>
                                <td class="col-md-4"><small>RG</small><br><?=sprintf('%d/%s', $cliente->rg, $cliente->rg_org_expedidor)?></td>
                                <td class="col-md-4"><small>Estado Civil</small><br><?=ucfirst($cliente->estado_civil)?>(a)</td>
                            </tr>
                            <tr>
                                <td colspan="2"><small>Endereço</small><br><?=sprintf('%s,%s%s%s', $cliente->logradouro, $cliente->numero, (!is_null($cliente->complemento)?', ':''), $cliente->complemento)?></td>
                                <td><small>CEP</small><br><?=System\Utilities::mask($cliente->cep, '##.###-###')?></td>
                            </tr>
                            <tr>
                                <td><small>Bairro</small><br><?=$cliente->bairro?></td>
                                <td><small>Cidade</small><br><?=$cliente->cidade?></td>
                                <td><small>Estado</small><br><?=$cliente->estado?></td>
                            </tr>
                            <tr>
                                <td><small>Contrato<br></small><?=sprintf('%06d', $contrato->id)?></td>
                                <td><small>Data<br></small><?=date('d/m/Y', strtotime($contrato->data))?></td>
                                <?php $status = ['Quitado', 'Ativo', 'Cancelado'];?>
                                <td><small>Situação<br></small><?=$status[$contrato->status]?></td>
                            </tr>
                            <tr>
                                <td><small>Entrada</small><br>R$ <?=number_format($contrato->entrada,2,',','.')?></td>
                                <td><small>Total de Parcelas</small><br><?=sprintf('%04d', $contrato->parcelas)?></td>
                                <td><small>Vencimento das Parcelas</small><br>Dia <?=$contrato->vencimento?></td>
                            </tr>
                            <tr>
                                <td><small>Quadra</small><br><?=$lote->quadra?></td>
                                <td><small>Lote</small><br><?=$lote->descricao?></td>
                                <td><small>Valor Total</small><br>R$ <?=number_format($lote->valor, 2, ',', '.')?></td>
                            </tr>
                            <tr>
                                <td class="col-md-4"><small>Parcelas Pagas</small><br><?=sprintf('%04d', $pagas->total)?></td>
                                <td class="col-md-4"><small>Parcelas Abertas</small><br><?=sprintf('%04d', $abertas->total)?></td>
                                <td class="col-md-4"><small>Parcelas Canceladas</small><br><?=sprintf('%04d', $canceladas->total)?></td>
                            </tr>
                            <tr>
                                <td><small>Total Pago</small><br>R$ <?=number_format($pagas->valor, 2, ',', '.')?></td>
                                <td><small>Total a Receber</small><br>R$ <?=number_format($abertas->valor, 2, ',', '.')?></td>
                                <td><small>Desconto/Cancelamento</small><br>R$ <?=number_format($canceladas->valor, 2, ',', '.')?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-condensed table-striped">
                        <tr>
                            <td class="col-md-6"><small>Multas</small><br>R$ <?=number_format($multas_juros->multa, 2, ',', '.')?></td>
                            <td class="col-md-6"><small>Juros</small><br>R$ <?=number_format($multas_juros->juros, 2, ',', '.')?></td>
                        </tr>
                    </table>
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descrição</th>
                                <th>Situação</th>
                                <th>Valor</th>
                                <th>Multa</th>
                                <th>Juros</th>
                                <th>Vencimento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $status = ['Aberta', 'Quitada', 'Cancelada'];
                            foreach($parcelas as $parcela):?>
                                <tr>
                                    <td><?=sprintf('%04d',$parcela->id)?></td>
                                    <td><?=$parcela->descricao?></td>
                                    <td><?=$status[$parcela->status]?></td>
                                    <td><?=number_format($parcela->valor, 2, ',', '.')?></td>
                                    <td><?=number_format($parcela->multa, 2, ',', '.')?></td>
                                    <td><?=number_format($parcela->juros, 2, ',', '.')?></td>
                                    <td><?=date('d/m/Y', strtotime($parcela->vencimento))?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    <p class="text-right"><small>Extrato gerado em <strong><?=date('d/m/Y')?></strong> por <strong><?=$usuario->usuario?></strong>.</small></p>
                </div>
            </div>
        </div>
    </body>
</html>
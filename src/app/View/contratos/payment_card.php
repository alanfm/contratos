<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <base href="<?=URL_BASE?>">
        <meta charset="UTF-8">
        <title>Carnê de Pagamento de <?=$comprador->nome?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="public/css/normalize.css">
        <style>
            body {
                font-family: Sans-Serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 3.3rem;
            }
            table td {
                border: 1px solid #000;
                padding: .1rem;
            }
            p, h3{
                margin: 0;
                padding: 0;
            }
            p {
                font-size: 10pt;
            }
            .text-small {
                font-size: 9pt;
            }
            .text-center {
                text-align: center;
            }
            ul {
                margin: 0;
                font-size: 10pt;
            }
            .col-1 {
                width: 25%;
            }
            .col-2 {
                width: 75%;
            }
        </style>
    </head>
    <body>
        <?php
        $count = 1;
        foreach($parcelas as $parcela):
            if ($parcela->status != 0) {
                $count++;
                continue;
            }
        ?>
        <table cellspacing="0" cellpadding="0" width="33%">
            <tbody>
                <tr>
                    <td class="col-1" colspan="2" style="text-align: center;"><img src="public/imgs/caixa.png" alt="" width="100px"></td>
                    <td class="col-2" colspan="4" style="text-align: center"><h3><?=strtoupper($empresa->nome)?></h3></td>
                </tr>
                <tr>
                    <td>
                        <p>Parcela/total</p>
                        <p class="text-center"><?=sprintf('%02d/%02d', $count++, count($parcelas))?></p>
                    </td>
                    <td>
                        <p>Valor</p>
                        <p class="text-center"><?='R$' . number_format($parcela->valor, 2, ',', '.')?></p>
                    </td>
                    <td class="col-2" colspan="4">
                        <p>PAGAMENTO: Depósito identificado ou tranferência para: <strong>Banco:</strong> <?=$conta->banco?>, <strong>Agência:</strong> <?=$conta->agencia?>, <strong>Conta:</strong> <?=$conta->conta?>, <strong>Operação:</strong> <?=$conta->operacao?></p>
                    </td>
                </tr>
                <tr>
                    <td class="col-1" colspan="2">
                        <p>Vecimento</p>
                        <p class="text-center"><?=date('d/m/Y', strtotime($parcela->vencimento))?></p>
                    </td>
                    <td colspan="3">
                        <p>Beneficiário:</p>
                        <p><?=$vendedor->nome?></p>
                    </td>
                    <td colspan="1">
                        <p>C.P.F.:</p>
                        <p><?=System\Utilities::mask($vendedor->cpf, '###.###.###-##')?></p>
                    </td>
                </tr>
                <tr>
                    <td class="col-1" colspan="2">
                        <p>Agência/Conta/Operação</p>
                        <p class="text-center"><?=$conta->agencia?>/<?=$conta->conta?>/<?=$conta->operacao?></p>
                    </td>
                    <td>
                        <p class="text-small">Data do documento</p>
                        <p class="text-center"><?=date('d/m/Y', strtotime($parcela->vencimento))?></p>
                    </td>
                    <td>
                        <p class="text-small">Número do documento</p>
                        <p class="text-center"><?=sprintf('%04d', $parcela->id)?></p>
                    </td>
                    <td>
                        <p class="text-small">Data de processamento</p>
                        <p class="text-center"><?=date('d/m/Y', strtotime($contrato->data))?></p>
                    </td>
                    <td>
                        <p class="text-small">Valor do documento</p>
                        <p class="text-center"><?='R$' . number_format($parcela->valor, 2, ',', '.')?></p>
                    </td>
                </tr>
                <tr>
                    <td class="col-1" colspan="2">
                        <p>(+) Multas/Juros</p>
                        <p class="text-center">&nbsp;</p>
                    </td>
                    <td class="col-2" colspan="4">
                        <p>Imóvel</p>
                        <p>Terrenos Altos Ventos / Quadra 01 / Lote 02</p>
                    </td>
                </tr>
                <tr>
                    <td class="col-1" colspan="2">
                        <p>(+) Outros acrescimos</p>
                        <p class="text-center">&nbsp;</p>
                    </td>
                    <td class="col-2" rowspan="3" colspan="4">
                        <p>Instruções</p>
                        <ul>
                            <li>Após vencimento cobrar multa de <?='R$' . number_format($conta->multa, 2, ',', '.')?> e juros de <?='R$' . number_format($conta->juros, 2, ',', '.')?> ao dia;</li>
                            <li>O pagamento das parcelas deverá ser efetuado através de deposito identificado ou transferência na conta mencionada acima;</li>
                            <li>Após pagamento, o pagador deverá enviar o comprovante para o E-mail <?=$vendedor->email?> ou pelo WhatsApp  <?=System\Utilities::mask($fone_vendedor->ddd . $fone_vendedor->numero, '(##) #####-####')?>.</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="col-1">
                        <p>(-) Valor cobrado</p>
                        <p class="text-center">&nbsp;</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="col-1">
                        <p>Pagador</p>
                        <p><?=$comprador->nome?></p>
                    </td>
                </tr>
                <tr>
                    <td class="col-1" colspan="2" rowspan="2">
                        <p>Numero do documento</p>
                        <p class="text-center"><?=sprintf('%04d', $parcela->id)?></p>
                    </td>
                    <td colspan="2">
                        <p>Pagador: <?=$comprador->nome?></p>
                    </td>
                    <td colspan="2">
                        <p>CPF: <?=System\Utilities::mask($comprador->cpf, '###.###.###-##')?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p><?=$comprador_endereco->logradouro?> <?=$comprador_endereco->numero?>, Bairro: <?=$comprador_endereco->bairro?>, CEP: <?=System\Utilities::mask($comprador_endereco->cep, '##.###-###')?>, <?=$comprador_endereco->cidade?>-<?=$comprador_endereco->estado?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php endforeach;?>
    </body>
</html>
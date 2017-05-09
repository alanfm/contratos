<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <base href="<?=URL_BASE?>">
        <meta charset="UTF-8">
        <title>Carnê de Pagamento</title>
        <link rel="stylesheet" href="public/css/normalize.css">
        <style>
            body {
                margin: 1rem;
                font-family: Sans-Serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 3rem;
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
                font-size: 9.5pt;
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
        <?php for ($i = 0; $i < 3; $i++):?>
        <table cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td class="col-1" colspan="2" style="text-align: center;"><img src="public/imgs/caixa.png" alt="" width="100px"></td>
                    <td class="col-2" colspan="4" style="text-align: center"><h3>TERRENO ALGODÕES - ALCÂNTARAS</h3></td>
                </tr>
                <tr>
                    <td>
                        <p>Parcela/total</p>
                        <p class="text-center">1/36</p>
                    </td>
                    <td>
                        <p>Valor</p>
                        <p class="text-center">R$ 100,02</p>
                    </td>
                    <td class="col-2" colspan="4">
                        <p>PAGAMENTO: Depósito identificado ou tranferência para:</p>
                        <p><strong>Conta:</strong> 566832-9, <strong>Agência:</strong> 6529-6, <strong>Operação:</strong> 13, <strong>Banco:</strong> Caixa Econômica Federal</p>
                    </td>
                </tr>
                <tr>
                    <td class="col-1" colspan="2">
                        <p>Vecimento</p>
                        <p class="text-center">12/06/2017</p>
                    </td>
                    <td colspan="3">
                        <p>Beneficiário:</p>
                        <p>FULANO DE TALS PEREIRA</p>
                    </td>
                    <td colspan="1">
                        <p>C.P.F.:</p>
                        <p>026.369.456-98</p>
                    </td>
                </tr>
                <tr>
                    <td class="col-1" colspan="2">
                        <p>Conta/Agencia/Operação</p>
                        <p class="text-center">566832-9/6529-6/13</p>
                    </td>
                    <td>
                        <p>Data do documento</p>
                        <p class="text-center">23/05/2017</p>
                    </td>
                    <td>
                        <p>Número do documento</p>
                        <p class="text-center">2566</p>
                    </td>
                    <td>
                        <p>Data de processamento</p>
                        <p class="text-center">23/05/2017</p>
                    </td>
                    <td>
                        <p>Valor do documento</p>
                        <p class="text-center">R$ 256,36</p>
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
                            <li>Após vencimento cobrar multa de R$ 11,39 e juros de R$ 1,13 ao dia;</li>
                            <li>O pagamento das parcelas deverá ser efetuado através de deposito identificado ou transferência na conta mencionada acima;</li>
                            <li>Após pagamento, o pagador deverá enviar o comprovante para o E-mail francalves_alc@hotmail.com ou pelo WhatsApp  (88) 99404 2327.</li>
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
                        <p>Fulano dos Anzois Pereira</p>
                    </td>
                </tr>
                <tr>
                    <td class="col-1" colspan="2" rowspan="2">
                        <p>Numero do documento</p>
                        <p class="text-center">2566</p>
                    </td>
                    <td colspan="2">
                        <p>Pagador: Fulano do Anzois Pereira</p>
                    </td>
                    <td colspan="2">
                        <p>CPF: 025.654.123-99</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p>Endereço: Rua Das Primeiras Damas S/N, Bairro: Nobreza, CEP: 63.654-321</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php endfor;?>
    </body>
</html>
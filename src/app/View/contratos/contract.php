<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <base href="<?=URL_BASE?>">
        <meta charset="UTF-8">
        <title>Contrato</title>
        <link href="https://fonts.googleapis.com/css?family=Gudea" rel="stylesheet">
        <link rel="stylesheet" href="public/css/normalize.css">
        <style>
            body {
                font-family: 'Gudea', sans-serif;
            }
            .contrato {
                text-align: justify;
            }
            table {
                width: 100%;
                margin-bottom: 4rem;
                text-align: center;
                border-collapse: separate; 
                border-spacing: 2rem;
            }
            td {
                border-top: 1px solid #000;
                width: 50%
            }
        </style>
    </head>
    <body>
        <div class="contrato">
            <h2>CONTRATO PARTICULAR DE COMPRA E VANDA QUE ENTRE SI FAZEM, COMO PROMITENTE(S) VENDEDOR(ES) E PROMISSÁRIO(S) COMPRADOR(ES) DESIGNADOS E QUALIFICADOS NA FORMA ABAIXO:</h2>
            <p>Pelo presente instrumento particular de PROMESSA DE COMPRA E VENDA, de um lado o(s) promitente(s) VENDEDOR(ES), nomeado(s) e qualificado(s) no Item 01, senhor(es) legítimo(s) possuidor(s) do IMOVEL mencionado no item 03, adquirido de conformidade do cartório de Registo Comarca de ALCÂNTARAS, e de outro lado o(s) promissário(s) COMPRADOR(ES) nomeado(s) e qualificado(s) no Item 02, e que o(s) promitente(s) VENDEDOR(ES), promete(s) vender ao(s) promissário(s) COMPRADOR(ES), e este(s) convenciona(m) adquirir-lhe(s), o imóvel descrito no Item 03, pelo preço certo e ajustado de R$ <?=number_format($lote->valor, 2, ',', '.')?> (<?php \App\Library\Extenso::valor($lote->valor); echo \App\Library\Extenso::numero(\App\Library\Extenso::MOEDA);?>), nos termos e condições estipuladas no Item 04, que mutuamente outorgam e aceitam a saber:</p>
            <h3>Quadro Resumo: <?=mb_strtoupper($terreno->descricao, 'UTF-8')?>.</h3>
            <h4>ITEM 01 – PROMITENTE(S) VENDEDOR(ES)</h4>
            <ul>
                <li><strong>Nome: </strong><?=$vendedor->nome?></li>
                <li><strong>Endereço: </strong><?=$vendedor->logradouro.' '.$vendedor->numero?></li>
                <li><strong>Bairro: </strong><?=$vendedor->bairro?></li>
                <li><strong>CEP: </strong><?=$vendedor->cep?></li>
                <li><strong>Cidade/UF: </strong><?=$vendedor->cidade.'/'.$vendedor->uf?></li>
                <li><strong>Data de Nascimento: </strong><?=date('d/m/Y', strtotime($vendedor->data_nascimento))?></li>
                <li><strong>C.P.F.: </strong><?=$vendedor->cpf?></li>
                <li><strong>R.G.: </strong><?=$vendedor->rg.' '.$vendedor->rg_org_expedidor?></li>
                <li><strong>Estado Civil: </strong><?=ucfirst($vendedor->estado_civil)?> (a)</li>
            </ul>
            <h4>ITEM 02 – PROMISSÁRIO(S) COMPRADOR(ES)</h4>
            <ul>
                <li><strong>Nome: </strong><?=$cliente->nome?></li>
                <li><strong>Endereço: </strong><?=$endereco->logradouro.' '.$endereco->numero?></li>
                <li><strong>Bairro: </strong><?=$endereco->bairro?></li>
                <li><strong>CEP: </strong><?=$endereco->cep?></li>
                <li><strong>Cidade/UF: </strong><?=$endereco->cidade.'/'.$endereco->uf?></li>
                <li><strong>Data de Nascimento: </strong><?=date('d/m/Y', strtotime($cliente->data_nascimento))?></li>
                <li><strong>C.P.F.: </strong><?=$cliente->cpf?></li>
                <li><strong>R.G.: </strong><?=$cliente->rg.' '.$cliente->rg_org_expedidor?></li>
                <li><strong>Estado Civil: </strong><?=ucfirst($cliente->estado_civil)?> (a)</li>
            </ul>
            <h4>ITEM 03 – DESCRIÇAO DO IMÓVEL E OBJETIVO</h4>
            <ul>
                <li><strong>Lote: </strong><?=$lote->descricao?></li>
                <li><strong>Quadra: </strong><?=$quadra->descricao?></li>
                <li><strong>Área Total: </strong><?=$lote->largura*$lote->comprimento?>m<sup>2</sup></li>
                <li>
                    <strong>Medidas: </strong>
                    <ul>
                        <li><strong>Frente: </strong><?=number_format($lote->largura, 2, ',', '.')?>m</li>
                        <li><strong>Fundo: </strong><?=number_format($lote->comprimento, 2, ',', '.')?>m</li>
                    </ul>
                </li>
            </ul>
            <ol type="a">
                <li>O promissário comprador declara ter ciência e concordar, sem restrições de qualquer natureza que em razão da conformação das características e especificações próprias dos lotes, deverá analisar e providenciar, às próprias expensas, as sondagens do solo necessário à elaboração do projeto de fundações e de escoamento de águas pluviais, tomando todas as demais medidas pertinentes, com vista e evitar prejuízos à edificação que implantará nos lotes e os lotes vizinhos.</li>
                <li>A área e as medidas do perímetro dos lotes poderão sofrer alterações, a maior ou menor, em até 2% (dois por cento), sem que tal fato gere direito a qualquer ressarcimento ou indenização.</li>
            </ol>
            <h4>ITEM 04 – DO PREÇO E CONDIÇÕES DE PAGAMENTO</h4>
            <p>Serão pagos pelo promitente(s) comprador (a, es) da seguinte forma:</p>
            <ol type="a">
                <li>R$ <?=number_format($contrato->entrada, 2, ',', '.')?> (<?php \App\Library\Extenso::valor($contrato->entrada); echo \App\Library\Extenso::numero(\App\Library\Extenso::MOEDA);?>) pago neste ato em moeda corrente, como sinal e princípio de pagamento.</li>
                <li>Restante a ser pagos em <?=$contrato->parcelas?> (<?php \App\Library\Extenso::valor($contrato->parcelas); echo \App\Library\Extenso::numero(\App\Library\Extenso::NUMERO);?>) parcelas fixas no valor de R$ <?=$parcela->valor?> (<?php \App\Library\Extenso::valor($parcela->valor); echo \App\Library\Extenso::numero(\App\Library\Extenso::MOEDA);?>) com a primeira para dia (<?=date('d/m/Y', strtotime($parcela->vencimento))?>) e o restante a cada dia <?=$contrato->vencimento?> dos meses subsequentes, com pagamentos a serem pagos em forma de deposito bancário.</li>
                <li>O promissário comprador (a)s declara ter conhecimento e concorda que o pagamento das parcelas será efetuado através de deposito identificado ou transferência na Conta: <?=$conta->conta?> Agencia: <?=$conta->agencia?> <?php if ($conta->operacao):?>Operação: <?=$conta->operacao?><?php endif;?>, <?=$conta->cliente?>, <?=$conta->banco?>. Que os mesmo serão entregues no ato da assinatura deste contrato.</li>
                <li>Após o vencimento será cobrado multa de R$ <?=number_format($conta->multa, 2, ',', '.')?> (<?php \App\Library\Extenso::valor($conta->multa); echo \App\Library\Extenso::numero(\App\Library\Extenso::MOEDA);?>) e juros de R$ <?=number_format($conta->juros, 2, ',', '.')?> (<?php \App\Library\Extenso::valor($conta->juros); echo \App\Library\Extenso::numero(\App\Library\Extenso::MOEDA);?>) ao dia.</li>
                <li>Na falta de pagamento, pelo promissário comprador (a)s de 03 (três) ou mais parcelas do preço, o contrato será rescindido de pleno direito, caso o promissário comprador seja notificado com aviso de recebimento. Sendo que promissário comprador será avisado no prazo de 15 dias conforme Artigo 474 do Código Civil.</li>
                <li>Caso promissário comprador perca o carnê entregue no ato da assinatura do contrato, será cobrado uma taxa de R$ <?=number_format($conta->carne, 2, ',', '.')?> (<?php \App\Library\Extenso::valor($conta->carne); echo \App\Library\Extenso::numero(\App\Library\Extenso::MOEDA);?>) para manutenção do sistema e pedidos ao banco para impressão dos mesmos, com prazo de 03 (três) dias úteis para entrega. Isso não impedirá o cômputo dos juros moratórios nem a multa pelo atraso.</li>
                <li>g)  Pagamento antecipados só terão descontos a partir de 05 (cinco) parcelas, sendo calculado o desconto proporcionalmente de 5% (cinco por cento) das 05 (cinco) parcelas em questão.</li>
            </ol>
            <h4>ITEM 05 – DA POSSE</h4>
            <p>O promitente vendedor obriga-se a entregar as benfeitorias prometidas no prazo máximo de 180 dias ao promissário comprador. A partir da transferência da posse do imóvel objeto do presente instrumento, o que ocorrerá após a quitação de todos os valores em aberto, o(s) promissário(s) comprador(es) passa(m) a responder pelos imposto, taxas despesas condominiais e outras despesas incidentes sobre o mesmo. Pelos débitos anteriores a essa data ainda que lançados ou cobrado posteriormente a data da transferência da passe, o(s) promitente(s) vendedor(es) será(ão) os únicos responsáveis.</p>
            <ul>
                <li>Não obstante o disposto no “Caput” desta cláusula, o promitente vendedor poderá permitir que o promissário comprador a(s) ingresse no lote para iniciar obras de edificação desde que:</li>
                <li>
                    <lo type="a">
                        <li>Tenham efetuado o pagamento mínimo de 50% (cinquenta por cento) do preço integral do lote.</li>
                        <li>Esteja consciente de que em caso de desistência ou quebra de contrato, os valores gastos com a construção não serão devolvidos.</li>
                        <li>Estejam sem atraso no pagamento das parcelas.</li>
                        <li>Construa a fossa séptica provisória, desde que permitidas pela legislação aplicável e observadas suas disposições, a qual, obrigatoriamente, deverá ser desativada pelo promitente comprador a(s) assim que o sistema de coleta de esgoto estiver em funcionamento.</li>
                    </lo>
                </li>
            </ul>
            <h4>ITEM 06 – DA ESCRITURA DEFINITIVA</h4>
            <p>A escritura participar definitiva estará disponível a partir da quitação dos pagamentos acordados neste contrato (Item 04).</p>
            <ol type="a">
                <li>Na hipótese do promissário comprador a(s) desejar vender ou fazer a transferência do presente contrato para terceiros, haverá um custo de R$ <?=number_format($conta->transferencia, 2, ',', '.')?> (<?php \App\Library\Extenso::valor($conta->transferencia); echo \App\Library\Extenso::numero(\App\Library\Extenso::MOEDA);?>) pela cessão e R$ <?=number_format($conta->carne, 2, ',', '.')?> (<?php \App\Library\Extenso::valor($conta->carne); echo \App\Library\Extenso::numero(\App\Library\Extenso::MOEDA);?>) para impressão de novo contrato e boletos.</li>
                <li>O promissário comprador deverá comunicar qualquer eventual modificação dos endereços, telefones ou qualificação, constantes do presente instrumento, sob pena de serem considerados como entregues as correspondências enviadas com a base nas informações contidas no quadro resumo.</li>
            </ol>
            <h4>ITEM 07 – DA IRREVOGABILIDADE E IRRETRATABILIDADE DESTE CONTRATO DE COMPRA E VENDA</h4>
            <p>O presente contrato é estabelecido em caráter irrevogável e irretratável, extensivo aos herdeiros e sucessores dos contratantes, a qualquer título, não comportando de parte, direito de arrependimento, conforme os artigos 417 à 420 do Novo Código Civil brasileiro, Lei 10.406/2002.</p>
            <p>Se por motivo maior havendo arrependimento ou outro fator partindo do vendedor, o mesmo terá que devolver 20% (vinte por cento) a mais do valor recebido dado por parte do promissário comprador (a)s.</p>
            <p>O arrependimento partido do promissário comprador, o mesmo perderá o valor dado da entrada e receberá de volta 60% (sessenta por cento) do valor das parcelas pagas.</p>
            <h4>ITEM 08 – DECLARAÇÕES FINAIS</h4>
            <p>O(s) promissário(s) COMPRADOR(ES), concorda(m) que todas as despesas com a transferência de débito ou escritura definitiva, tais como: imposto de transmissão, laudêmio se houver, (taxa de transferência, seguro antecipado, FCVS, taxa de inscrição e expediente), no caso de transferência, escritura, registro de cartório e despachantes, corram, exclusivamente por sua conta.</p>
            <ol type="a">
                <li>O(s) promitente(s) VENDEDOR(ES) declara(m) ter(em) feito a venda boa, firme e valiosa, e que responderá(ão), por evicção de direito.</li>
                <li>Manter quis quer cursos de água eventualmente existente em lotes é obrigação de ambas as partes.</li>
                <li>Não alterar área de preservação permanente – APP eventualmente existente nos lotes ou área verdes do loteamento é obrigação de ambas as partes.</li>
                <li>Fica declarado, que este instrumento é irrevogável, estando incurso nos Artigos 417 à 420 do Código Civil brasileiro.</li>
                <li>As partes elegem o foro da comarca de SOBRAL, para dirimirem quais quer dúvidas oriundas do presente instrumento, renunciando a qualquer outro por mais especial que se apresente.</li>
                <li>O presente instrumento obriga em todas os seus termos, itens condições os contratantes pro si mesmos, seus bens, herdeiros e sucessores a qualquer título.</li>
            </ol>
            <p>E, assim, por se acharem justos e contratados, as partes assinam o presente instrumento em 03 (três) vias de igual teor e forma para um só efeito.</p>
            <p style="text-align: right;"><?=$terreno->cidade.'-'.$terreno->uf?>,
            <?php
            $meses = [1=>'janeiro', 2=>'fevereiro', 3=>'março', 4=>'abril', 5=>'maio', 6=>'junho', 7=>'julho', 8=>'agosto', 9=>'setembro', 10=>'outubro', 11=>'novembro', 12=>'dezembro'];
            $data = explode('/', date('d/m/Y', strtotime($contrato->data)));
            echo $data[0], ' de ', $meses[(int)$data[1]], ' de ', $data[2];
            ?></p>
            <table>
                <tr>
                    <td colspan="1">
                        Promitente Vendedor(a)
                    </td>
                </tr>
                <tr>
                    <td>
                        Promissário Comprador(a)
                    </td>
                    <td>
                        Cônjuge
                    </td>
                </tr>
                <tr>
                    <td>
                        Testemunha<br>
                        CPF: ______________________________________
                    </td>
                    <td>
                        Testemunha<br>
                        CPF: ______________________________________
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
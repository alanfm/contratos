<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Parcelas;
use App\Storage\Contratos;
use App\Storage\Pessoas;
use App\Storage\Empresas;
use App\Storage\Contas;
use App\Storage\Enderecos;
use App\Storage\Telefones;

class Relatorios extends Controller
{
    public function parcelas()
    {
        $data['total_abertas'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                                 'conditions'=>['status = 0']]);
        $data['total_canceladas'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                                    'conditions'=>['status = 2']]);
        $data['total_atrazadas'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                                    'conditions'=>['vencimento < ? AND status = 0', date('Y-m-d')]]);

        $date[0] = date('Y-m-d', strtotime(sprintf('%s-%s-%s', date('Y'), date('m'), 1)));
        $date[1] = date('Y-m-d', strtotime(sprintf('%s-%s-%s', date('Y'), date('m'), date('t'))));
        $data['a_vencer'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                            'conditions'=>['(status = 0) AND (vencimento BETWEEN ? AND ?)', $date[0], $date[1]]]);

        $data['recebidas'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                             'conditions'=>['quitada BETWEEN ? AND ?', $date[0], $date[1]]]);
        $this->content('relatorios/parcelas', $data);
    }
}
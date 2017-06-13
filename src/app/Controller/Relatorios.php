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
    public function __construct()
    {
        Authentication::manager();
        parent::__construct();
    }
    
    public function parcelas()
    {
        $data['total_abertas'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                                 'conditions'=>['status = 0']]);
        $data['total_pagas'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                                 'conditions'=>['status = 1']]);
        $data['total_canceladas'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                                    'conditions'=>['status = 2']]);
        $data['total_atrasadas'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                                    'conditions'=>['vencimento < ? AND status = 0', date('Y-m-d')]]);

        $date[0] = date('Y-m-d', strtotime(sprintf('%s-%s-%s', date('Y'), date('m'), 1)));
        $date[1] = date('Y-m-d', strtotime(sprintf('%s-%s-%s', date('Y'), date('m'), date('t'))));
        $data['a_vencer'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                            'conditions'=>['(status = 0) AND (vencimento BETWEEN ? AND ?)', $date[0], $date[1]]]);

        $data['recebidas'] = Parcelas::find(['select'=>'SUM(VALOR) AS valor, COUNT(id) AS total',
                                             'conditions'=>['quitada BETWEEN ? AND ?', $date[0], $date[1]]]);

        $join = 'INNER JOIN pessoas ON (pessoas.id = contratos.pessoas_id) INNER JOIN lotes ON (lotes.id = contratos.lotes_id) INNER JOIN quadras ON (quadras.id = lotes.quadras_id) INNER JOIN terrenos ON (terrenos.id = quadras.terrenos_id)';

        $data['atrasadas'] = Parcelas::all(['select'=>'parcelas.id as parcela, parcelas.vencimento, parcelas.valor as valor, lotes.descricao as lote, quadras.descricao as quadra, terrenos.descricao as terreno, pessoas.nome as cliente',
                                            'conditions'=>['parcelas.vencimento < ? AND parcelas.status = 0', date('Y-m-d')],
                                            'joins'=>['contratos', $join]]);

        $this->content('relatorios/parcelas', $data);
    }

    public function contratos()
    {

    }

    public function clientes()
    {
        
    }
}
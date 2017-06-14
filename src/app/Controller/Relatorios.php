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
use App\Storage\Usuarios;
use App\Storage\Sessoes;

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

    public function parcelas_date()
    {
        $data['data'] = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->check_date(filter_input(INPUT_POST, 'date_init'))) {
                $_SESSION['alert'] = ['message'=>'A data inicial não é válida!', 'error'=>'danger'];
                Utilities::redirect('relatorios/parcelas/data');
                exit();
            }


            if (!$this->check_date(filter_input(INPUT_POST, 'date_end'))) {
                $_SESSION['alert'] = ['message'=>'A data final não é válida!', 'error'=>'danger'];
                Utilities::redirect('relatorios/parcelas/data');
                exit();
            }

            $date_init = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'date_init'))));
            $date_end = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'date_end'))));
            $situacao = filter_input(INPUT_POST, 'situacao');

            if ($date_end <= $date_init) {
                $_SESSION['alert'] = ['message'=>'A data inicial deve ser menor que a data final!', 'error'=>'danger'];
                Utilities::redirect('relatorios/parcelas/data');
                exit();
            }

            $join = 'INNER JOIN pessoas ON (pessoas.id = contratos.pessoas_id) INNER JOIN lotes ON (lotes.id = contratos.lotes_id) INNER JOIN quadras ON (quadras.id = lotes.quadras_id) INNER JOIN terrenos ON (terrenos.id = quadras.terrenos_id)';

            $data['data'] = Parcelas::all(['select'=>'parcelas.id as parcela, pessoas.nome as cliente, parcelas.vencimento, parcelas.valor as valor, parcelas.multa, parcelas.juros, parcelas.status, contratos.id as contrato, lotes.descricao as lote, quadras.descricao as quadra, terrenos.descricao as terreno',
                                            'conditions'=>['(parcelas.vencimento BETWEEN ? AND ?) AND parcelas.status = ?', $date_init, $date_end, $situacao],
                                            'joins'=>['contratos', $join]]);
        }

        $this->content('relatorios/parcelas_date', $data);
    }

    private function check_date($date)
    {
        $tmp = explode('/', $date);
        return checkdate($tmp[1], $tmp[0], $tmp[2]);
    }

    public function contratos()
    {

    }

    public function clientes()
    {
        
    }

    public function usuarios()
    {
        $data['total'] = Usuarios::count();
        $data['total_admin'] = Usuarios::count(['conditions'=>['nivel = ?', 'admin']]);
        $data['total_manager'] = Usuarios::count(['conditions'=>['nivel = ?', 'manager']]);
        $data['total_salesman'] = Usuarios::count(['conditions'=>['nivel = ?', 'salesman']]);
        $data['usuarios'] = Usuarios::all();
        $data['sessoes'] = $this->sum_interval_sessions();
        $this->content('relatorios/usuarios', $data);
    }

    public function sum_interval_sessions()
    {
        $users = Usuarios::all();
        $usuarios = [];

        $init = new \DateTime(date('Y-m-d H:i:s'));
        foreach ($users as $user) {
            $sessions = Sessoes::all(['conditions'=>['usuarios_id = ?', $user->id]]);
            $tmp['usuario'] = $user->usuario;
            $tmp['email'] = $user->email;

            $end = $init;
            var_dump($init);
            var_dump($end);

            foreach ($sessions as $session) {
                $diff = (date_create($session->final))->diff(date_create($session->inicio));
                $end->add(new \DateInterval('PT'.$diff->format('%h').'H'.$diff->format('%i').'M'.$diff->format('%s').'S'));
                var_dump($init->diff($end)->format('%H:%I:%S'));
            }

            $tmp['all_time'] = $end->diff($init)->format('%D/%M/%Y %H:%I:%S');

            $usuarios[] = (object)$tmp;
        }

        return $usuarios;
    }
}
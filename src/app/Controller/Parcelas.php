<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Parcelas as Model;
use App\Storage\Contratos;
use App\Storage\Pessoas;
use App\Storage\Empresas;
use App\Storage\Contas;
use App\Storage\Enderecos;
use App\Storage\Telefones;

class Parcelas extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function payment_card($id)
    {
        $this->data['conta'] = Contas::find('last');
        $this->data['empresa'] = Empresas::find('last');
        $this->data['vendedor'] = Pessoas::all(['conditions'=>['tipo = ?', 'vendedor']])[0];
        $this->data['fone_vendedor'] = Telefones::find(['conditions'=>['pessoas_id = ?', $this->data['vendedor']->id]]);
        $this->data['contrato'] = Contratos::find($id);
        $this->data['comprador'] = Pessoas::find($this->data['contrato']->pessoas_id);

        $join = 'INNER JOIN estados ON (estados.id = cidades.estados_id)';
        $this->data['comprador_endereco'] = Enderecos::all(['select'=>'enderecos.*, cidades.nome as cidade, estados.uf as estado',
                                                            'conditions'=>['pessoas_id = ?', $this->data['comprador']->id],
                                                            'joins'=>['cidades', $join]])[0];

        $this->data['parcelas'] = Model::all(['conditions'=>['contratos_id = ?', $id]]);
        $this->view('contratos/payment_card', $this->data)->show();
    }

    public function payment()
    {
        $id = filter_input(INPUT_POST, 'parcela');
        $data['quitada'] = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'quitada'))));
        $data['recebido'] = filter_input(INPUT_POST, 'recebido');
        $data['multa'] = filter_input(INPUT_POST, 'multa');
        $data['juros'] = filter_input(INPUT_POST, 'juros');
        $data['documento'] = filter_input(INPUT_POST, 'documento');
        $data['status'] = true;

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('contratos/detalhes/'.Model::find($id)->contratos_id);
            exit();
        }        

        $_SESSION['alert'] = ['message'=>'Pagamento realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('contratos/detalhes/'.Model::find($id)->contratos_id);
        exit();
    }

    public function cancel($id, $token)
    {
        $data['quitada'] = null;
        $data['recebido'] = null;
        $data['documento'] = null;
        $data['status'] = 2;

        if ($token !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('contratos/detalhes/'.Model::find($id)->contratos_id);
            exit();
        }        

        $_SESSION['alert'] = ['message'=>'Pagamento realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('contratos/detalhes/'.Model::find($id)->contratos_id);
        exit();
    }

    public function edit($id)
    {
        $data['parcela'] = Model::find($id);
        $this->content('contratos/parcelas', $data);
    }

    public function update($id)
    {
        $data['quitada'] = filter_input(INPUT_POST, 'quitada');
        $data['recebido'] = filter_input(INPUT_POST, 'recebido');
        $data['multa'] = filter_input(INPUT_POST, 'multa');
        $data['juros'] = filter_input(INPUT_POST, 'juros');
        $data['status'] = filter_input(INPUT_POST, 'status');
        $data['documento'] = filter_input(INPUT_POST, 'documento');

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('contratos/detalhes/'.Model::find($id)->contratos_id);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('contratos/detalhes/'.Model::find($id)->contratos_id);
        exit();
    }
}
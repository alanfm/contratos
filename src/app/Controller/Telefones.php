<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Telefones as Model;
use App\Storage\Pessoas;

class Telefones extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($cliente)
    {
        $this->form(null);
        $this->data['cliente'] = Pessoas::find($cliente);
        $this->data['data'] = isset($_SESSION['search'])? unserialize($_SESSION['search']): $this->read($cliente);
        unset($_SESSION['search']);
        $this->content('pessoas/telefones', $this->data);
    }

    public function edit($cliente, $id)
    {
        $this->data['edit'] = true;
        $this->form($this->read($cliente, $id));
        $this->data['cliente'] = Pessoas::find($cliente);
        $this->data['data'] = $this->read( $cliente);
        $this->content('pessoas/telefones', $this->data);
    }

    public function create($cliente)
    {
        $data['numero'] = filter_input(INPUT_POST, 'numero');
        $data['ddd'] = filter_input(INPUT_POST, 'ddd');
        $data['operadora'] = filter_input(INPUT_POST, 'operadora');
        $data['tipo'] = filter_input(INPUT_POST, 'tipo');
        $data['pessoas_id'] = $cliente;

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::create($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('clientes/telefones/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('clientes/telefones/'.$cliente);
        exit();
    }

    public function read($cliente, $id = null)
    {
        if (!isset($_SESSION['telefones']['pagination'])) {
            $this->pagination($cliente);
        }

        if (is_null($id)) {
            $data = Model::all(['select'=>'*',
                                'conditions'=>['pessoas_id = ?', $cliente],
                                'limit'=>10,
                                'offset'=>$_SESSION['telefones']['pagination'],
                                'order'=>'id DESC']);

            $count = Model::count();

            if ($count > 10) {
                $_SESSION['telefones']['count'] = $count % 10? (int)($count / 10) + 1: $count / 10;
            } else {
                $_SESSION['telefones']['count'] = 1;
            }

            return $data;
        }

        return Model::find($id);
    }

    public function update($cliente, $id)
    {
        $data['numero'] = filter_input(INPUT_POST, 'numero');
        $data['ddd'] = filter_input(INPUT_POST, 'ddd');
        $data['operadora'] = filter_input(INPUT_POST, 'operadora');
        $data['tipo'] = filter_input(INPUT_POST, 'tipo');      

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('clientes/telefones/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('clientes/telefones/'.$cliente);
        exit();
    }

    public function delete($cliente, $id)
    {
        if (!Model::find($id)->delete()) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('clientes/telefones/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro apagado com sucesso!', 'error'=>'success'];
        Utilities::redirect('clientes/telefones/'.$cliente);
        exit();

    }

    public function search($cliente)
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('clientes/telefones/'.$cliente);
            exit();
        }

        $_SESSION['clientes/telefones/'.$id]['search'] = true;
        $_SESSION['search'] = serialize(Model::all(['conditions'=>['(pessoas_id = ?) AND (numero LIKE CONCAT("%",?,"%"))',
                                                                   $cliente,
                                                                   filter_input(INPUT_POST, 'search')],
                                                    'order'=>'id DESC']));
        Utilities::redirect('clientes/telefones/'.$cliente);
        exit();
    }

    public function form($model = null)
    {
        $this->data['form']['numero'] = is_object($model)? $model->numero: null;
        $this->data['form']['ddd'] = is_object($model)? $model->ddd: null;
        $this->data['form']['tipo'] = is_object($model)? $model->tipo: null;
        $this->data['form']['operadora'] = is_object($model)? $model->operadora: null;
        return;
    }

    public function pagination($cliente, $page = 1, $redirect = true)
    {
        $_SESSION['telefones']['pagination'] = $page > 1? ($page - 1) * 10: 0;
        $_SESSION['telefones']['current_page'] = $page > 1? $page: 1;

        if ($redirect) {
            Utilities::redirect('clientes/telefones/'.$cliente);
        }

        exit();
    }
}
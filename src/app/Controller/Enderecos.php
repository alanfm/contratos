<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Enderecos as Model;
use App\Storage\Pessoas;
use App\Storage\Cidades;
use App\Storage\Estados;

class Enderecos extends Controller
{
    public function __construct()
    {
        Authentication::salesman();
        parent::__construct();
    }

    public function index($cliente)
    {
        $this->form(null);
        $this->data['cliente'] = Pessoas::find($cliente);
        $this->data['estados'] = Estados::all();
        $this->data['data'] = isset($_SESSION['search'])? unserialize($_SESSION['search']): $this->read($cliente);
        unset($_SESSION['search']);
        $this->content('pessoas/enderecos', $this->data);
    }

    public function edit($cliente, $id)
    {
        $this->data['edit'] = true;
        $this->form($this->read($cliente, $id));
        $this->data['cliente'] = Pessoas::find($cliente);
        $this->data['estados'] = Estados::All();
        $this->data['cidades'] = Cidades::all(['conditions'=>['estados_id = ?', $this->data['form']['estado']]]);
        $this->data['data'] = $this->read( $cliente);
        $this->content('pessoas/enderecos', $this->data);
    }

    public function create($cliente)
    {
        $data['logradouro'] = filter_input(INPUT_POST, 'logradouro');
        $data['numero'] = filter_input(INPUT_POST, 'numero');
        $data['complemento'] = filter_input(INPUT_POST, 'complemento');
        $data['bairro'] = filter_input(INPUT_POST, 'bairro');
        $data['cep'] = filter_input(INPUT_POST, 'cep');
        $data['cidades_id'] = filter_input(INPUT_POST, 'cidade');
        $data['pessoas_id'] = $cliente;

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::create($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('clientes/enderecos/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('clientes/enderecos/'.$cliente);
        exit();
    }

    public function read($cliente, $id = null)
    {
        if (!isset($_SESSION['enderecos']['pagination'])) {
            $this->pagination($cliente);
        }

        if (is_null($id)) {
            $join = 'INNER JOIN estados ON (estados.id = cidades.estados_id)';
            $data = Model::all(['select'=>'enderecos.*, cidades.nome as cidade, estados.uf as estado',
                                'conditions'=>['pessoas_id = ?', $cliente],
                                'joins'=>['cidades', $join],
                                'limit'=>10,
                                'offset'=>$_SESSION['enderecos']['pagination'],
                                'order'=>'id DESC']);

            $count = Model::count();

            if ($count > 10) {
                $_SESSION['enderecos']['count'] = $count % 10? (int)($count / 10) + 1: $count / 10;
            } else {
                $_SESSION['enderecos']['count'] = 1;
            }

            return $data;
        }

        return Model::find($id);
    }

    public function update($cliente, $id)
    {
        $data['logradouro'] = filter_input(INPUT_POST, 'logradouro');
        $data['numero'] = filter_input(INPUT_POST, 'numero');
        $data['complemento'] = filter_input(INPUT_POST, 'complemento');
        $data['bairro'] = filter_input(INPUT_POST, 'bairro');
        $data['cep'] = filter_input(INPUT_POST, 'cep');
        $data['cidades_id'] = filter_input(INPUT_POST, 'cidade');     

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('clientes/enderecos/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('clientes/enderecos/'.$cliente);
        exit();
    }

    public function delete($cliente, $id)
    {
        if (!Model::find($id)->delete()) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('clientes/enderecos/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro apagado com sucesso!', 'error'=>'success'];
        Utilities::redirect('clientes/enderecos/'.$cliente);
        exit();

    }

    public function search($cliente)
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('clientes/enderecos/'.$cliente);
            exit();
        }

        $_SESSION['clientes/enderecos/'.$id]['search'] = true;
        $join = 'INNER JOIN estados ON (estados.id = cidades.estados_id)';
        $_SESSION['search'] = serialize(Model::all(['select'=>'enderecos.*, cidades.nome as cidade, estados.uf as estado',
                                                    'joins'=>['cidades', $join],
                                                    'conditions'=>['(enderecos.pessoas_id = ?) AND (enderecos.logradouro LIKE CONCAT("%",?,"%"))',
                                                                   $cliente,
                                                                   filter_input(INPUT_POST, 'search')],
                                                    'order'=>'id DESC']));
        Utilities::redirect('clientes/enderecos/'.$cliente);
        exit();
    }

    public function form($model = null)
    {
        $this->data['form']['logradouro'] = is_object($model)? $model->logradouro: null;
        $this->data['form']['numero'] = is_object($model)? $model->numero: null;
        $this->data['form']['complemento'] = is_object($model)? $model->complemento: null;
        $this->data['form']['bairro'] = is_object($model)? $model->bairro: null;
        $this->data['form']['cep'] = is_object($model)? $model->cep: null;
        $this->data['form']['cidade'] = is_object($model)? $model->cidades_id: null;
        $this->data['form']['estado'] = is_object($model)? Estados::find(Cidades::find($model->cidades_id)->estados_id)->id: null;
        return;
    }

    public function pagination($cliente, $page = 1, $redirect = true)
    {
        $_SESSION['enderecos']['pagination'] = $page > 1? ($page - 1) * 10: 0;
        $_SESSION['enderecos']['current_page'] = $page > 1? $page: 1;

        if ($redirect) {
            Utilities::redirect('clientes/enderecos/'.$cliente);
        }

        exit();
    }
}
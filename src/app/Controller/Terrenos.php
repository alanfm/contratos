<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Terrenos as Model;
use App\Storage\Estados;
use App\Storage\Cidades;

class Terrenos extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->form(null);
        $this->data['estados'] = Estados::all();
        $this->data['data'] = isset($_SESSION['search'])? unserialize($_SESSION['search']): $this->read();
        unset($_SESSION['search']);
        $this->content('terrenos/terrenos', $this->data);
    }

    public function edit($id)
    {
        $this->data['edit'] = true;
        $this->form($this->read($id));
        $this->data['data'] = $this->read();
        $this->content('terrenos/terrenos', $this->data);
    }

    public function create()
    {
        $this->data['descricao'] = filter_input(INPUT_POST, 'descricao');
        $this->data['bairro'] = filter_input(INPUT_POST, 'bairro');
        $this->data['cidades_id'] = filter_input(INPUT_POST, 'cidade');

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::create($this->data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('terrenos');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('terrenos');
        exit();
    }

    public function read($id = null)
    {
        if (!isset($_SESSION['terrenos']['pagination'])) {
            $this->pagination(1, false);
        }

        if (is_null($id)) {
            $data = Model::all(['select'=>'*',
                                'limit'=>10,
                                'offset'=>$_SESSION['terrenos']['pagination'],
                                'order'=>'id DESC']);

            $count = Model::count();

            if ($count > 10) {
                $_SESSION['terrenos']['count'] = $count % 10? (int)($count / 10) + 1: $count / 10;
            } else {
                $_SESSION['terrenos']['count'] = 1;
            }

            return $data;
        }

        return Model::find($id);
    }

    public function update($id)
    {
        $data['descricao'] = filter_input(INPUT_POST, 'descricao');        

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('terrenos');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('terrenos');
        exit();
    }

    public function delete($id)
    {
        if (!Model::find($id)->delete()) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('terrenos');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro apagado com sucesso!', 'error'=>'success'];
        Utilities::redirect('terrenos');
        exit();

    }

    public function search()
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('terrenos');
            exit();
        }

        $_SESSION['terrenos']['search'] = true;
        $_SESSION['search'] = serialize(Model::all(['conditions'=>['descricao LIKE CONCAT("%",?,"%")', filter_input(INPUT_POST, 'search')],
                                                                   'order'=>'id DESC']));
        Utilities::redirect('terrenos');
        exit();
    }

    private function form($model)
    {
        if (!is_object($model)) {
            $this->data['form']['descricao'] = null;
            $this->data['form']['bairro'] = null;
            $this->data['form']['cidade'] = null;
            $this->data['form']['estado'] = null;
            return;
        }

        $this->data['form']['descricao'] = $model->descricao;
        $this->data['form']['bairro'] = $model->bairro;
        $this->data['form']['cidade'] = $model->cidades_id;
        $this->data['form']['estado'] = Estado::find(Cidades::find($model->cidades_id)->estados_id);
        return false;
    }

    public function pagination($page = 1, $redirect = true)
    {
        $_SESSION['terrenos']['pagination'] = $page > 1? ($page - 1) * 10: 0;
        $_SESSION['terrenos']['current_page'] = $page > 1? $page: 1;

        if ($redirect) {
            Utilities::redirect('terrenos');
        }

        exit();
    }
}
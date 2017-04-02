<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Quadras as Model;

class Quadras extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->form(null);
        $this->data['data'] = isset($_SESSION['search'])? unserialize($_SESSION['search']): $this->read();
        unset($_SESSION['search']);
        $this->content('terrenos/quadras', $this->data);
    }

    public function edit($id)
    {
        $this->data['edit'] = true;
        $this->form($this->read($id));
        $this->data['data'] = $this->read();
        $this->content('terrenos/quadras', $this->data);
    }

    public function create()
    {
        $this->data['descricao'] = filter_input(INPUT_POST, 'descricao');

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::create($this->data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('/terrenos/quadras');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('terrenos/quadras');
        exit();
    }

    public function read($id = null)
    {
        if (is_null($id)) {
            return Model::all(['select'=>'*', 'limit'=>10, 'offset'=>0, 'order'=>'id DESC']);
        }

        return Model::find($id);
    }

    public function update($id)
    {
        $data['descricao'] = filter_input(INPUT_POST, 'descricao');        

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('terrenos/quadras');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('terrenos/quadras');
        exit();
    }

    public function delete($id)
    {
        if (!Model::find($id)->delete()) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('terrenos/quadras');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro apagado com sucesso!', 'error'=>'success'];
        Utilities::redirect('terrenos/quadras');
        exit();

    }

    public function search()
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('terrenos/quadras');
            exit();
        }

        $_SESSION['search'] = serialize(Model::all(['conditions'=>['descricao LIKE CONCAT("%",?,"%")', filter_input(INPUT_POST, 'search')],
                                                                   'limit'=>10, 'offset'=>0, 'order'=>'id DESC']));
        Utilities::redirect('terrenos/quadras');
        exit();
    }

    public function form($quadra)
    {
        if (!is_object($quadra)) {
            $this->data['form']['descricao'] = null;
            return;
        }

        $this->data['form']['descricao'] = $quadra->descricao;
        return false;
    }
}
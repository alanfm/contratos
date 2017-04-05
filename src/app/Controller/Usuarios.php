<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Usuarios as Model;

class Usuarios extends Controller
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
        $this->content('usuarios/usuarios', $this->data);
    }

    public function edit($id)
    {
        $this->data['edit'] = true;
        $this->form($this->read($id));
        $this->data['data'] = $this->read();
        $this->content('usuarios/usuarios', $this->data);
    }

    public function create()
    {
        $data['usuario'] = filter_input(INPUT_POST, 'usuario');
        $data['password'] = password_hash(filter_input(INPUT_POST, 'senha'), PASSWORD_DEFAULT);
        $data['email'] = filter_input(INPUT_POST, 'email');
        $data['status'] = filter_input(INPUT_POST, 'situacao');
        $data['nivel'] = filter_input(INPUT_POST, 'nivel');

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::create($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('usuarios');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('usuarios');
        exit();
    }

    public function read($id = null)
    {
        if (!isset($_SESSION['usuarios']['pagination'])) {
            $this->pagination();
        }

        if (is_null($id)) {
            $data = Model::all(['select'=>'id, usuario, email, status, nivel, criado_em, ultimo_acesso',
                                'limit'=>10,
                                'offset'=>$_SESSION['usuarios']['pagination'],
                                'order'=>'id DESC']);

            $count = Model::count();

            if ($count > 10) {
                $_SESSION['usuarios']['count'] = $count % 10? (int)($count / 10) + 1: $count / 10;
            } else {
                $_SESSION['usuarios']['count'] = 1;
            }

            return $data;
        }

        return Model::find($id);
    }

    public function update($id)
    {        
        $data['usuario'] = filter_input(INPUT_POST, 'usuario');
        $data['password'] = password_hash(filter_input(INPUT_POST, 'senha'), PASSWORD_DEFAULT);
        $data['email'] = filter_input(INPUT_POST, 'email');
        $data['status'] = filter_input(INPUT_POST, 'situacao');
        $data['nivel'] = filter_input(INPUT_POST, 'nivel');       

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('usuarios');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('usuarios');
        exit();
    }

    public function delete($id)
    {
        if (!Model::find($id)->delete()) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('usuarios');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro apagado com sucesso!', 'error'=>'success'];
        Utilities::redirect('usuarios');
        exit();

    }

    public function search()
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('usuarios');
            exit();
        }

        $_SESSION['usuarios']['search'] = true;
        $_SESSION['search'] = serialize(Model::all(['select'=>'id, usuario, email, status, nivel, criado_em, ultimo_acesso',
                                                    'conditions'=>['usuario LIKE CONCAT("%",?,"%")', filter_input(INPUT_POST, 'search')],
                                                    'order'=>'id DESC']));
        Utilities::redirect('usuarios');
        exit();
    }

    public function form($model = null)
    {
        $this->data['form']['usuario'] = is_object($model)? $model->usuario: null;
        $this->data['form']['email'] = is_object($model)? $model->email: null;
        $this->data['form']['nivel'] = is_object($model)? $model->nivel: null;
        $this->data['form']['status'] = is_object($model)? $model->status: null;
        return;
    }

    public function pagination($page = 1, $redirect = true)
    {
        $_SESSION['usuarios']['pagination'] = $page > 1? ($page - 1) * 10: 0;
        $_SESSION['usuarios']['current_page'] = $page > 1? $page: 1;

        if ($redirect) {
            Utilities::redirect('usuarios');
        }

        exit();
    }
}
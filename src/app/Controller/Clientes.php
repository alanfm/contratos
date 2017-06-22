<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Pessoas as Model;
use App\Storage\Telefones;
use App\Storage\Enderecos;
use App\Storage\Contratos;

class Clientes extends Controller
{    
    private $limit = 10;

    public function __construct()
    {
        Authentication::salesman();
        parent::__construct();
    }

    public function index()
    {
        $this->form(null);
        $this->data['data'] = isset($_SESSION['search'])? unserialize($_SESSION['search']): $this->read();
        unset($_SESSION['search']);
        $this->content('pessoas/clientes', $this->data);
    }

    public function edit($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $this->data['edit'] = true;
        $this->form($this->read($id));
        $this->data['data'] = $this->read();
        $this->content('pessoas/clientes', $this->data);
    }

    public function create()
    {
        $data['nome'] = filter_input(INPUT_POST, 'nome');
        $data['data_nascimento'] = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'data_nascimento'))));
        $data['cpf'] = filter_input(INPUT_POST, 'cpf');
        $data['rg'] = filter_input(INPUT_POST, 'rg');
        $data['rg_emissao'] = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'rg_emissao'))));
        $data['rg_org_expedidor'] = filter_input(INPUT_POST, 'rg_org_expedidor');
        $data['estado_civil'] = filter_input(INPUT_POST, 'estado_civil');
        $data['tipo'] = 'cliente';

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::create($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('clientes');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('clientes');
        exit();
    }

    private function read($id = null)
    {
        if (!is_null($id)) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        }

        if (!isset($_SESSION['clientes']['pagination'])) {
            $this->pagination();
        }

        if (is_null($id)) {
            $data = Model::all(['select'=>'*',
                                'conditions'=>['tipo = ?', 'cliente'],
                                'limit'=>$this->limit,
                                'offset'=>$_SESSION['clientes']['pagination'],
                                'order'=>'id DESC']);

            $count = Model::count();
            if ($count >= $this->limit) {
                $_SESSION['clientes']['count'] = $count % $this->limit? (int)($count / $this->limit) + 1: $count / $this->limit;
            } else {
                $_SESSION['clientes']['count'] = 0;
            }

            return $data;
        }

        return Model::find($id);
    }

    public function update($id)
    {        
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $data['nome'] = filter_input(INPUT_POST, 'nome');
        $data['data_nascimento'] = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'data_nascimento'))));
        $data['cpf'] = filter_input(INPUT_POST, 'cpf');
        $data['rg'] = filter_input(INPUT_POST, 'rg');
        $data['rg_emissao'] = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'rg_emissao'))));
        $data['rg_org_expedidor'] = filter_input(INPUT_POST, 'rg_org_expedidor');
        $data['estado_civil'] = filter_input(INPUT_POST, 'estado_civil');      

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('clientes');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('clientes');
        exit();
    }

    public function delete($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if (!Model::find($id)->delete()) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('clientes');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro apagado com sucesso!', 'error'=>'success'];
        Utilities::redirect('clientes');
        exit();
    }

    public function search()
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('clientes');
            exit();
        }

        $_SESSION['clientes']['search'] = true;
        $_SESSION['search'] = serialize(Model::all(['select'=>'*',
                                                    'conditions'=>['nome LIKE CONCAT("%",?,"%")', filter_input(INPUT_POST, 'search')],
                                                    'order'=>'id DESC']));
        Utilities::redirect('clientes');
        exit();
    }

    public function details($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $this->data['cliente'] = Model::find($id);
        $this->data['telefones'] = Telefones::all(['conditions'=>['pessoas_id = ?', $id]]);

        $join = 'INNER JOIN estados ON (cidades.estados_id = estados.id)';
        $this->data['enderecos'] = Enderecos::all(['select'=>'enderecos.*, cidades.nome as cidade, estados.uf as estado',
                                                   'conditions'=>['pessoas_id = ?', $id],
                                                   'joins'=>['cidades', $join]]);

        $join = 'INNER JOIN quadras ON (quadras.id = lotes.quadras_id) INNER JOIN terrenos ON (terrenos.id = quadras.terrenos_id)';
        $this->data['contratos'] = Contratos::all(['select'=>'contratos.*, lotes.descricao as lote, quadras.descricao as quadra, terrenos.descricao as terreno',
                                                   'conditions'=>['pessoas_id = ?', $id],
                                                   'joins'=>['lotes', $join]]);
        $this->content('pessoas/clientes_details', $this->data);
    }

    private function form($model = null)
    {
        $this->data['form']['nome'] = is_object($model)? $model->nome: null;
        $this->data['form']['data_nascimento'] = is_object($model)? date('d/m/Y', strtotime($model->data_nascimento)): null;
        $this->data['form']['cpf'] = is_object($model)? $model->cpf: null;
        $this->data['form']['rg'] = is_object($model)? $model->rg: null;
        $this->data['form']['rg_emissao'] = is_object($model)? date('d/m/Y', strtotime($model->rg_emissao)): null;
        $this->data['form']['rg_org_expedidor'] = is_object($model)? $model->rg_org_expedidor: null;
        $this->data['form']['estado_civil'] = is_object($model)? $model->estado_civil: null;
        return;
    }

    public function pagination($page = 1, $redirect = true)
    {        
        $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
        $redirect = filter_var($redirect);

        $_SESSION['clientes']['pagination'] = $page > 1? ($page - 1) * 10: 0;
        $_SESSION['clientes']['current_page'] = $page > 1? $page: 1;

        if ($redirect) {
            Utilities::redirect('clientes');
        }

        exit();
    }

    public static function relationship($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        return (is_object(Telefones::find(['conditions'=>['pessoas_id = ?', $id]])) ||
                is_object(Enderecos::find(['conditions'=>['pessoas_id = ?', $id]])) ||
                is_object(Contratos::find(['conditions'=>['pessoas_id = ?', $id]])));
    }
}
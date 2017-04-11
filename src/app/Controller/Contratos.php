<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Contratos as Model;
use App\Storage\Pessoas;
use App\Storage\Lotes;
use App\Storage\Quadras;
use App\Storage\Terrenos;
use App\Storage\Usuarios;

class Contratos extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($cliente)
    {
        $this->form(null);
        $this->data['cliente'] = Pessoas::find($cliente);
        $this->data['terrenos'] = Terrenos::all();
        $this->data['data'] = $this->read($cliente);
        unset($_SESSION['search']);
        $this->content('contratos/contratos', $this->data);
    }

    public function edit($cliente, $id)
    {
        $this->data['edit'] = true;
        $this->form($this->read($cliente, $id));
        $this->data['cliente'] = Pessoas::find($cliente);
        $this->data['lotes'] = Lotes::all(['conditions'=>'quadras_id = ? AND situacao = aberto', $this->data['form']['quadra']]);
        $this->data['quadras'] = Quadra::all(['conditions'=>'terrenos_id = ?', $this->data['form']['terreno']]);
        $this->data['terrenos'] = Terrenos::all();
        $this->data['data'] = $this->read( $cliente);
        $this->content('contratos/contratos', $this->data);
    }

    public function create($cliente)
    {
        $data['data'] = date('Y-m-d');
        $data['entrada'] = filter_input(INPUT_POST, 'entrada');
        $data['parcelas'] = filter_input(INPUT_POST, 'parcelas');
        $data['vencimento'] = filter_input(INPUT_POST, 'vencimento');
        $data['status'] = filter_input(INPUT_POST, 'status');
        $data['lotes_id'] = filter_input(INPUT_POST, 'lote');
        $data['usuarios_id'] = 1; // Corrigir quando implementar móduto de Autenticação!
        $data['pessoas_id'] = $cliente;

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() ||            
            !Lotes::find($data['lotes_id'])->update_attributes(['situacao'=>'vendido']) || // Muda situação do lote para vendido
            !Model::create($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('contratos/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('contratos/'.$cliente);
        exit();
    }

    public function read($cliente, $id = null)
    {
        if (!isset($_SESSION['contratos']['pagination'])) {
            $this->pagination($cliente);
        }

        if (is_null($id)) {
            $join = 'INNER JOIN quadras ON (quadras.id = lotes.quadras_id) INNER JOIN terrenos ON (terrenos.id = quadras.terrenos_id)';
            $data = Model::all(['select'=>'contratos.*, lotes.descricao as lote, quadras.descricao as quadra, terrenos.descricao as terreno',
                                'conditions'=>['pessoas_id = ?', $cliente],
                                'joins'=>['lotes', $join],
                                'limit'=>10,
                                'offset'=>$_SESSION['contratos']['pagination'],
                                'order'=>'id DESC']);

            $count = Model::count();

            if ($count > 10) {
                $_SESSION['contratos']['count'] = $count % 10? (int)($count / 10) + 1: $count / 10;
            } else {
                $_SESSION['contratos']['count'] = 1;
            }

            return $data;
        }

        return Model::find($id);
    }

    public function update($cliente, $id)
    {
        $data['entrada'] = filter_input(INPUT_POST, 'entrada');
        $data['parcelas'] = filter_input(INPUT_POST, 'parcelas');
        $data['vencimento'] = filter_input(INPUT_POST, 'vencimento');
        $data['status'] = filter_input(INPUT_POST, 'status');
        $data['lotes_id'] = filter_input(INPUT_POST, 'lote');     

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('contratos/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('contratos/'.$cliente);
        exit();
    }

    public function delete($cliente, $id)
    {
        if (!Model::find($id)->delete()) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('contratos/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro apagado com sucesso!', 'error'=>'success'];
        Utilities::redirect('contratos/'.$cliente);
        exit();

    }

    public function search($cliente)
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('contratos/'.$cliente);
            exit();
        }

        $_SESSION['contratos/'.$id]['search'] = true;
        $join = 'INNER JOIN quadras ON (quadras.id = lotes.quadras_id) INNER JOIN terrenos ON (terrenos.is = quadras.terrenos_id)';
        $_SESSION['search'] = serialize(Model::all(['select'=>'enderecos.*, cidades.nome as cidade, estados.uf as estado',
                                                    'joins'=>['lotes', $join],
                                                    'conditions'=>['(contratos.pessoas_id = ?) AND (contratos.logradouro LIKE CONCAT("%",?,"%"))',
                                                                   $cliente,
                                                                   filter_input(INPUT_POST, 'search')],
                                                    'order'=>'id DESC']));
        Utilities::redirect('contratos/'.$cliente);
        exit();
    }

    public function form($model = null)
    {
        $this->data['form']['data'] = is_object($model)? $model->data: null;
        $this->data['form']['entrada'] = is_object($model)? $model->entrada: null;
        $this->data['form']['parcelas'] = is_object($model)? $model->parcelas: null;
        $this->data['form']['vencimento'] = is_object($model)? $model->vencimento: null;
        $this->data['form']['status'] = is_object($model)? $model->status: null;
        $this->data['form']['lotes'] = is_object($model)? $model->lotess_id: null;
        $this->data['form']['quadra'] = is_object($model)? Quadra::find(Lotes::find($model->lotes_id)->quadras_id)->id: null;
        $this->data['form']['terreno'] = is_object($model)? Terreno::find(Quadra::find(Lotes::find($model->lotes_id)->quadras_id)->terrenos_id)->id: null;
        return;
    }

    public function pagination($cliente, $page = 1, $redirect = true)
    {
        $_SESSION['contratos']['pagination'] = $page > 1? ($page - 1) * 10: 0;
        $_SESSION['contratos']['current_page'] = $page > 1? $page: 1;

        if ($redirect) {
            Utilities::redirect('contratos/'.$cliente);
        }

        exit();
    }
}
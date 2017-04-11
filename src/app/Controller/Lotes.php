<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Lotes as Model;
use App\Storage\Quadras;
use App\Storage\Terrenos;

class Lotes extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->form(null);
        $this->data['terrenos'] = Terrenos::all();
        $this->data['data'] = isset($_SESSION['search'])? unserialize($_SESSION['search']): $this->read();
        unset($_SESSION['search']);
        $this->content('terrenos/lotes', $this->data);
    }

    public function edit($id)
    {
        $this->data['edit'] = true;
        $this->form($this->read($id));
        $this->data['data'] = $this->read();
        $this->data['terrenos'] = Terrenos::all();
        $this->data['quadras'] = Quadras::all(['conditions'=>['terrenos_id = ?', $this->data['form']['terreno']]]);
        $this->content('terrenos/lotes', $this->data);
    }

    public function create()
    {
        $data['descricao'] = filter_input(INPUT_POST, 'descricao');
        $data['largura'] = str_replace(',', '.', filter_input(INPUT_POST, 'largura'));
        $data['comprimento'] = str_replace(',', '.', filter_input(INPUT_POST, 'comprimento'));
        $data['valor'] = str_replace(',', '.', filter_input(INPUT_POST, 'valor'));;
        $data['situacao'] = filter_input(INPUT_POST, 'situacao');
        $data['quadras_id'] = filter_input(INPUT_POST, 'quadra');

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::create($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('terrenos/lotes');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('terrenos/lotes');
        exit();
    }

    public function read($id = null)
    {
        if (!isset($_SESSION['lotes']['pagination'])) {
            $this->pagination();
        }

        if (is_null($id)) {
            $join = 'INNER JOIN terrenos ON (terrenos.id = quadras.terrenos_id)';
            $data = Model::all(['select'=>'lotes.*, quadras.descricao as quadra, terrenos.descricao as terreno',
                                'joins'=>['quadras', $join],
                                'limit'=>10,
                                'offset'=>$_SESSION['lotes']['pagination'],
                                'order'=>'id DESC']);

            $count = Model::count();

            if ($count > 10) {
                $_SESSION['lotes']['count'] = $count % 10? (int)($count / 10) + 1: $count / 10;
            } else {
                $_SESSION['lotes']['count'] = 1;
            }

            return $data;
        }

        return Model::find($id);
    }

    public function update($id)
    {
        $data['descricao'] = filter_input(INPUT_POST, 'descricao');
        $data['largura'] = filter_input(INPUT_POST, 'largura');
        $data['comprimento'] = filter_input(INPUT_POST, 'comprimento');
        $data['valor'] = filter_input(INPUT_POST, 'valor');
        $data['situacao'] = filter_input(INPUT_POST, 'situacao');
        $data['quadras_id'] = filter_input(INPUT_POST, 'quadra');

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('terrenos/lotes');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('terrenos/lotes');
        exit();
    }

    public function delete($id)
    {
        if (!Model::find($id)->delete()) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('terrenos/lotes');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro apagado com sucesso!', 'error'=>'success'];
        Utilities::redirect('terrenos/lotes');
        exit();

    }

    public function search()
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('terrenos/lotes');
            exit();
        }

        $_SESSION['lotes']['search'] = true;        
        $join = 'INNER JOIN terrenos ON (terrenos.id = quadras.terrenos_id)';
        $_SESSION['search'] = serialize(Model::all(['select'=>'lotes.*, quadras.descricao as quadra, terrenos.descricao as terreno',
                                                    'conditions'=>['lotes.descricao LIKE CONCAT("%",?,"%")', filter_input(INPUT_POST, 'search')],
                                                    'joins'=>['quadras', $join],
                                                    'order'=>'id DESC']));
        Utilities::redirect('terrenos/lotes');
        exit();
    }

    private function form($model)
    {
        if (!is_object($model)) {
            $this->data['form']['descricao'] = null;
            $this->data['form']['comprimento'] = null;
            $this->data['form']['largura'] = null;
            $this->data['form']['valor'] = null;
            $this->data['form']['situacao'] = null;
            $this->data['form']['quadra'] = null;
            $this->data['form']['terreno'] = null;
            return;
        }

        $this->data['form']['descricao'] = $model->descricao;
        $this->data['form']['comprimento'] = $model->comprimento;
        $this->data['form']['largura'] = $model->largura;
        $this->data['form']['valor'] = $model->valor;
        $this->data['form']['situacao'] = $model->situacao;
        $this->data['form']['quadra'] = $model->quadras_id;
        $this->data['form']['terreno'] = Terrenos::find(Quadras::find($model->quadras_id)->terrenos_id)->id;

        return;
    }

    public function pagination($page = 1, $redirect = true)
    {
        $_SESSION['lotes']['pagination'] = $page > 1? ($page - 1) * 10: 0;
        $_SESSION['lotes']['current_page'] = $page > 1? $page: 1;

        if ($redirect) {
            Utilities::redirect('terrenos/lotes');
        }

        exit();
    }    

    public function lotes_by_quadra($quadra)
    {
        foreach (Model::all(['conditions'=>['quadras_id = ?', $quadra]]) as $lote) {
            $data[] = ['id'=>$lote->id, 'descricao'=>$lote->descricao];
        }

        return $this->outputJSON($data);
    }
}
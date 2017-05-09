<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Pessoas;
use App\Storage\Contas;
use App\Storage\Empresas;

class Settings extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['create_vendedor'] = $this->form_vendedor()? 1: 0;
        $this->data['create_conta'] = $this->form_conta()? 1: 0;
        $this->data['create_empresa'] = $this->form_empresa()? 1: 0;

        $this->content('pessoas/settings', $this->data);
    }    

    public function vendedor()
    {
        $data['nome'] = filter_input(INPUT_POST, 'nome');
        $data['email'] = filter_input(INPUT_POST, 'email');
        $data['data_nascimento'] = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'data_nascimento'))));
        $data['cpf'] = filter_input(INPUT_POST, 'cpf');
        $data['rg'] = filter_input(INPUT_POST, 'rg');
        $data['rg_emissao'] = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'rg_emissao'))));
        $data['rg_org_expedidor'] = filter_input(INPUT_POST, 'rg_org_expedidor');
        $data['estado_civil'] = filter_input(INPUT_POST, 'estado_civil');
        $data['tipo'] = 'vendedor';

        if (!filter_input(INPUT_POST, 'create')) {
            if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Pessoas::create($data)) {
                $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
                Utilities::redirect('configuracoes');
                exit();
            }
        } else {
            if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Pessoas::find('last')->update_attributes($data)) {
                $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
                Utilities::redirect('configuracoes');
                exit();
            }
        }

        $_SESSION['alert'] = ['message'=>'Operação realizada com sucesso!', 'error'=>'success'];
        Utilities::redirect('configuracoes');
        exit();
    }

    public function conta()
    {
        $data['banco'] = filter_input(INPUT_POST, 'banco');
        $data['agencia'] = filter_input(INPUT_POST, 'agencia');
        $data['conta'] = filter_input(INPUT_POST, 'conta');
        $data['operacao'] = filter_input(INPUT_POST, 'operacao');
        $data['multa'] = filter_input(INPUT_POST, 'multa');
        $data['juros'] = filter_input(INPUT_POST, 'juros');


        if (!filter_input(INPUT_POST, 'create')) {
            if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Contas::create($data)) {
                $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
                Utilities::redirect('configuracoes');
                exit();
            }
        } else {
            if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Contas::find('last')->update_attributes($data)) {
                $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
                Utilities::redirect('configuracoes');
                exit();
            }
        }

        $_SESSION['alert'] = ['message'=>'Operação realizada com sucesso!', 'error'=>'success'];
        Utilities::redirect('configuracoes');
        exit();
    }

    public function empresa()
    {
        $data['nome'] = filter_input(INPUT_POST, 'nome');
        $data['cnpj'] = filter_input(INPUT_POST, 'cnpj');


        if (!filter_input(INPUT_POST, 'create')) {
            if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Empresas::create($data)) {
                $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
                Utilities::redirect('configuracoes');
                exit();
            }
        } else {
            if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Empresas::find('last')->update_attributes($data)) {
                $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
                Utilities::redirect('configuracoes');
                exit();
            }
        }

        $_SESSION['alert'] = ['message'=>'Operação realizada com sucesso!', 'error'=>'success'];
        Utilities::redirect('configuracoes');
        exit();
    }

    public function form_vendedor()
    {
        $vendedor = Pessoas::count(['conditions'=>['tipo = ?', 'vendedor']]);

        if ($vendedor) {
            $model = Pessoas::all(['conditions'=>['tipo = ?', 'vendedor']])[0];
        }

        $this->data['form']['nome'] = $vendedor? $model->nome: null;
        $this->data['form']['email'] = $vendedor? $model->email: null;
        $this->data['form']['data_nascimento'] = $vendedor? date('d/m/Y', strtotime($model->data_nascimento)): null;
        $this->data['form']['cpf'] = $vendedor? $model->cpf: null;
        $this->data['form']['rg'] = $vendedor? $model->rg: null;
        $this->data['form']['rg_emissao'] = $vendedor? date('d/m/Y', strtotime($model->rg_emissao)): null;
        $this->data['form']['rg_org_expedidor'] = $vendedor? $model->rg_org_expedidor: null;
        $this->data['form']['estado_civil'] = $vendedor? $model->estado_civil: null;

        return $vendedor;
    }

    public function form_conta()
    {
        $contas = Contas::count();

        if ($contas) {
            $model = Contas::find('last');
        }

        $this->data['form']['banco'] = $contas? $model->banco: null;
        $this->data['form']['agencia'] = $contas? $model->agencia: null;
        $this->data['form']['conta'] = $contas? $model->conta: null;
        $this->data['form']['operacao'] = $contas? $model->operacao: null;
        $this->data['form']['multa'] = $contas? $model->multa: null;
        $this->data['form']['juros'] = $contas? $model->juros: null;

        return $contas;
    }

    public function form_empresa()
    {
        $empresa = Empresas::count();

        if ($empresa) {
            $model = Empresas::find('last');
        }

        $this->data['form']['empresa'] = $empresa? $model->nome: null;
        $this->data['form']['cnpj'] = $empresa? $model->cnpj: null;

        return $empresa;
    }
}
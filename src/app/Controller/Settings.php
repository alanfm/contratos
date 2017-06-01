<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Pessoas;
use App\Storage\Contas;
use App\Storage\Empresas;
use App\Storage\Cidades;
use App\Storage\Estados;
use App\Storage\Enderecos;

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

        if ($this->data['form']['id']) {
            $this->data['create_endereco'] = $this->form_endereco($this->data['form']['id'])? 1: 0;
        }

        $this->data['estados'] = Estados::all();
        $this->data['cidades'] = Cidades::all(['conditions'=>['estados_id = ?', $this->data['form']['estado']]]);

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
        $data['cliente'] = filter_input(INPUT_POST, 'cliente');
        $data['multa'] = filter_input(INPUT_POST, 'multa');
        $data['juros'] = filter_input(INPUT_POST, 'juros');
        $data['carne'] = filter_input(INPUT_POST, 'carne');
        $data['transferencia'] = filter_input(INPUT_POST, 'transferencia');


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

    public function endereco()
    {
        $data['logradouro'] = filter_input(INPUT_POST, 'logradouro');
        $data['numero'] = filter_input(INPUT_POST, 'numero');
        $data['complemento'] = filter_input(INPUT_POST, 'complemento');
        $data['bairro'] = filter_input(INPUT_POST, 'bairro');
        $data['cep'] = filter_input(INPUT_POST, 'cep');
        $data['cidades_id'] = filter_input(INPUT_POST, 'cidade');
        $data['pessoas_id'] = filter_input(INPUT_POST, 'cliente');

        if (!filter_input(INPUT_POST, 'create')) {
            if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Enderecos::create($data)) {
                $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
                Utilities::redirect('configuracoes');
                exit();
            }
        } else {
            if (filter_input(INPUT_POST, 'token') !== Utilities::token() ||
                !Enderecos::find(['conditions'=>['pessoas_id = ?', filter_input(INPUT_POST, 'cliente')]])->update_attributes($data)) {
                $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
                Utilities::redirect('configuracoes');
                exit();
            }
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('configuracoes');
        exit();
    }

    public function form_vendedor()
    {
        $vendedor = Pessoas::count(['conditions'=>['tipo = ?', 'vendedor']]);

        if ($vendedor) {
            $model = Pessoas::all(['conditions'=>['tipo = ?', 'vendedor']])[0];
        }

        $this->data['form']['id'] = $vendedor? $model->id: null;
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
        $this->data['form']['cliente'] = $contas? $model->cliente: null;
        $this->data['form']['multa'] = $contas? $model->multa: null;
        $this->data['form']['juros'] = $contas? $model->juros: null;
        $this->data['form']['carne'] = $contas? $model->carne: null;
        $this->data['form']['transferencia'] = $contas? $model->transferencia: null;

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

    public function form_endereco($pessoa)
    {
        $endereco = Enderecos::count(['conditions'=>['pessoas_id = ?', $pessoa]]);

        if ($endereco) {
            $model = Enderecos::all(['conditions'=>['pessoas_id = ?', $pessoa]])[0];
        }

        $this->data['form']['logradouro'] = $endereco? $model->logradouro: null;
        $this->data['form']['numero'] = $endereco? $model->numero: null;
        $this->data['form']['complemento'] = $endereco? $model->complemento: null;
        $this->data['form']['bairro'] = $endereco? $model->bairro: null;
        $this->data['form']['cep'] = $endereco? $model->cep: null;
        $this->data['form']['cidade'] = $endereco? $model->cidades_id: null;
        $this->data['form']['estado'] = $endereco? Estados::find(Cidades::find($model->cidades_id)->estados_id)->id: null;

        return $endereco;
    }
}
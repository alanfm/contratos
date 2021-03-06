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
use App\Storage\Parcelas;
use App\Storage\Enderecos;
use App\Storage\Contas;
use App\Storage\Empresas;
use Spipu\Html2Pdf\Html2Pdf as PDF;

class Contratos extends Controller
{
    public function __construct()
    {
        Authentication::salesman();
        parent::__construct();
    }

    public function index($cliente)
    {
        $cliente = filter_var($cliente, FILTER_SANITIZE_NUMBER_INT);

        $this->form(null);
        $this->data['cliente'] = Pessoas::find($cliente);
        $this->data['terrenos'] = Terrenos::all();
        $this->data['data'] = $this->read($cliente);
        unset($_SESSION['search']);
        $this->content('contratos/contratos', $this->data);
    }

    public function edit($cliente, $id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $cliente = filter_var($cliente, FILTER_SANITIZE_NUMBER_INT);

        $this->data['edit'] = true;
        $this->form($this->read($cliente, $id));
        $this->data['cliente'] = Pessoas::find($cliente);
        $this->data['lote'] = Lotes::find(Model::find($id)->lotes_id);
        $this->data['lotes'] = Lotes::all(['conditions'=>['quadras_id = ? AND situacao = ?', $this->data['form']['quadra'], 'aberto']]);
        $this->data['quadras'] = Quadras::all(['conditions'=>['terrenos_id = ?', $this->data['form']['terreno']]]);
        $this->data['terrenos'] = Terrenos::all();
        $this->data['data'] = $this->read( $cliente);
        $this->content('contratos/contratos', $this->data);
    }

    public function create($cliente)
    {
        $cliente = filter_var($cliente, FILTER_SANITIZE_NUMBER_INT);

        $data['data'] = date('Y-m-d');
        $data['entrada'] = filter_input(INPUT_POST, 'entrada');
        $data['parcelas'] = filter_input(INPUT_POST, 'parcelas');
        $data['vencimento'] = filter_input(INPUT_POST, 'vencimento');
        $data['status'] = filter_input(INPUT_POST, 'status');
        $data['lotes_id'] = filter_input(INPUT_POST, 'lote');
        $data['usuarios_id'] = $_SESSION['user_id']; // Corrigir quando implementar móduto de Autenticação!
        $data['pessoas_id'] = $cliente;

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() ||            
            !Lotes::find($data['lotes_id'])->update_attributes(['situacao'=>'vendido']) || // Muda situação do lote para vendido
            !Model::create($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('contratos/'.$cliente);
            exit();
        }

        $valor = (Lotes::find($data['lotes_id'])->valor - $data['entrada'])/$data['parcelas'];
        // Método de manipulação de data não otimizado
        $date = explode('-', date('Y-m-d'));
        $date[2] = $data['vencimento'];
        $date = implode('-', $date);
        $date = \DateTime::createFromFormat('Y-m-d', $date);

        $contratos_id = Model::find('last')->id;

        for ($i = 0; $i < $data['parcelas']; $i++) {
            $par['descricao'] = sprintf("Parcela %02d", $i+1);
            $par['valor'] = $valor;
            $par['status'] = false;
            $par['vencimento'] = $date->add(new \DateInterval('P1M'))->format('Y-m-d');
            $par['contratos_id'] = $contratos_id;

            if (!Parcelas::create($par)) {
                $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
                Utilities::redirect('contratos/'.$cliente);
                exit();
            }
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('contratos/'.$cliente);
        exit();
    }

    public function read($cliente, $id = null)
    {
        $cliente = filter_var($cliente, FILTER_SANITIZE_NUMBER_INT);
        if (!is_null($id)) {
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        }

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
        $cliente = filter_var($cliente, FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $data['vencimento'] = filter_input(INPUT_POST, 'vencimento');

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('contratos/'.$cliente);
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('contratos/'.$cliente);
        exit();
    }

    public function cancel($cliente, $id, $page)
    {
        $cliente = filter_var($cliente, FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $page = filter_var($page);

        if (!Model::find($id)->update_attributes(['status'=>2])) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar cancelar o contrato!', 'error'=>'danger'];
            Utilities::redirect($page.'/detalhes/'.$cliente);
            exit();
        }

        if (!Lotes::find(Model::find($id)->lotes_id)->update_attributes(['situacao'=>'aberto'])) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar cancelar o contrato!', 'error'=>'danger'];
            Utilities::redirect($page.'/detalhes/'.$cliente);
            exit();            
        }

        $parcelas = Parcelas::all(['conditions'=>['contratos_id = ?', $id]]);

        foreach ($parcelas as $parcela) {
            if ($parcela->status != 1) {
                if (!Parcelas::find($parcela->id)->update_attributes(['status'=>2])) {                
                    $_SESSION['alert'] = ['message'=>'Erro ao tentar cancelar o contrato!', 'error'=>'danger'];
                    Utilities::redirect($page.'/detalhes/'.$cliente);
                    exit();
                }
            }
        }

        $_SESSION['alert'] = ['message'=>'Contrato cancelado com sucesso!', 'error'=>'success'];
        Utilities::redirect($page.'/detalhes/'.$cliente);
        exit();
    }

    public function search($cliente)
    {
        $cliente = filter_var($cliente, FILTER_SANITIZE_NUMBER_INT);

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

    private function form($model = null)
    {
        $this->data['form']['data'] = is_object($model)? $model->data: null;
        $this->data['form']['entrada'] = is_object($model)? $model->entrada: null;
        $this->data['form']['parcelas'] = is_object($model)? $model->parcelas: null;
        $this->data['form']['vencimento'] = is_object($model)? $model->vencimento: null;
        $this->data['form']['status'] = is_object($model)? $model->status: null;
        $this->data['form']['lote'] = is_object($model)? $model->lotes_id: null;
        $this->data['form']['quadra'] = is_object($model)? Quadras::find(Lotes::find($model->lotes_id)->quadras_id)->id: null;
        $this->data['form']['terreno'] = is_object($model)? Terrenos::find(Quadras::find(Lotes::find($model->lotes_id)->quadras_id)->terrenos_id)->id: null;
        return;
    }

    public function pagination($cliente, $page = 1, $redirect = true)
    {
        $cliente = filter_var($cliente, FILTER_SANITIZE_NUMBER_INT);
        $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
        $redirect = filter_var($redirect);

        $_SESSION['contratos']['pagination'] = $page > 1? ($page - 1) * 10: 0;
        $_SESSION['contratos']['current_page'] = $page > 1? $page: 1;

        if ($redirect) {
            Utilities::redirect('contratos/'.$cliente);
        }

        exit();
    }

    public function details($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $join = 'INNER JOIN quadras ON (quadras.id = lotes.quadras_id) INNER JOIN terrenos ON (terrenos.id = quadras.terrenos_id)';
        $data['contrato'] = Model::all(['select'=>'contratos.*, lotes.descricao as lote, lotes.valor, quadras.descricao as quadra, terrenos.descricao as terreno',
                            'conditions'=>['contratos.id = ?', $id],
                            'joins'=>['lotes', $join]])[0];
        $data['parcelas'] = Parcelas::all(['conditions'=>['contratos_id = ?', $id]]);
        $data['parcelas_pagas'] = Parcelas::count(['conditions'=>['status = 1 AND contratos_id = ?', $id]]);

        $data['valor_recebido'] = $this->sum_parcelas($id) + Model::find($id)->entrada;

        $data['cliente'] = Pessoas::find($data['contrato']->pessoas_id);
        $this->content('contratos/details', $data);
    }

    private function sum_parcelas($contrato)
    {
        $contrato = filter_var($contrato, FILTER_SANITIZE_NUMBER_INT);
        $total = 0;
        foreach(Parcelas::all(['conditions'=>['contratos_id = ? AND status = 1', $contrato]]) as $parcela) {
            $total += $parcela->recebido;
        }

        return $total;
    }

    public function impress($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        
        $data['contrato'] = Model::find($id);
        $data['parcela'] = Parcelas::find(['conditions'=>['contratos_id = ?', $data['contrato']->id]]);
        $data['lote'] = Lotes::find(Model::find($id)->lotes_id);
        $data['quadra'] = Quadras::find($data['lote']->quadras_id);

        $join = 'INNER JOIN estados ON (estados.id = cidades.estados_id)';
        $data['terreno'] = Terrenos::all(['select'=>'terrenos.*, cidades.nome as cidade, estados.uf',
                                          'conditions'=>['terrenos.id = ?',$data['quadra']->terrenos_id],
                                          'joins'=>['cidades', $join]])[0];

        $data['conta'] = Contas::find('first');
        $data['cliente'] = Pessoas::all($data['contrato']->pessoas_id);

        $join = 'INNER JOIN estados ON (estados.id = cidades.estados_id)';
        $data['endereco'] = Enderecos::all(['select'=>'enderecos.*, cidades.nome as cidade, estados.uf',
                                            'conditions'=>['pessoas_id = ?', $data['cliente']->id],
                                            'joins'=>['cidades', $join]])[0];

        $join = 'INNER JOIN enderecos ON (enderecos.pessoas_id = pessoas.id) INNER JOIN cidades ON (enderecos.cidades_id = cidades.id) INNER JOIN estados ON (estados.id = cidades.estados_id)';
        $data['vendedor'] = Pessoas::all(['select'=>'pessoas.*, enderecos.logradouro, enderecos.numero, enderecos.bairro, enderecos.cep,
                                                     cidades.nome as cidade, estados.uf',
                                         'conditions'=>['tipo = ?', 'vendedor'],
                                         'joins'=>[$join]])[0];

        $this->view('contratos/contract')->data($data)->show();
    }

    public function extract($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $data['empresa'] = Empresas::find('first');

        $data['contrato'] = $contrato = Model::find($id);

        $join = 'INNER JOIN terrenos ON (quadras.terrenos_id = terrenos.id)';
        $data['lote'] = Lotes::find(['select'=>'lotes.*, quadras.descricao as quadra, terrenos.descricao as terreno',
                                     'conditions'=>['lotes.id = ?', $contrato->lotes_id],
                                     'joins'=>['quadras',$join]]);

        $join = 'INNER JOIN estados ON (estados.id = cidades.estados_id)';
        $data['cliente'] = Enderecos::all(['select'=>'pessoas.*, enderecos.logradouro, enderecos.numero, enderecos.complemento, enderecos.bairro, enderecos.cep, cidades.nome as cidade, estados.nome as estado',
                                         'conditions'=>['enderecos.pessoas_id = ?', $contrato->pessoas_id],
                                         'joins'=>['pessoas', 'cidades', $join]])[0];

        $data['parcelas'] = Parcelas::all(['conditions'=>['contratos_id = ?',$id]]);
        $data['pagas'] = Parcelas::find(['select'=>'COUNT(id) as total, SUM(valor) as valor',
                                         'conditions'=>['contratos_id = ? AND status = 1', $contrato->id]]);
        $data['abertas'] = Parcelas::find(['select'=>'COUNT(id) as total, SUM(valor) as valor',
                                           'conditions'=>['contratos_id = ? AND status = 0', $contrato->id]]);
        $data['canceladas'] = Parcelas::find(['select'=>'COUNT(id) as total, SUM(valor) as valor',
                                              'conditions'=>['contratos_id = ? AND status = 2', $contrato->id]]);
        $data['multas_juros'] = Parcelas::find(['select'=>'SUM(multa) as multa, SUM(juros) as juros',
                                                'conditions'=>['contratos_id = ?', $contrato->id]]);
        $data['usuario'] = Usuarios::find($_SESSION['user_id']);

        $this->view('contratos/extract')->data($data)->show();
    }
}
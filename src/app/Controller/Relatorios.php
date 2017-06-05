<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Parcelas;
use App\Storage\Contratos;
use App\Storage\Pessoas;
use App\Storage\Empresas;
use App\Storage\Contas;
use App\Storage\Enderecos;
use App\Storage\Telefones;

class Relatorios extends Controller
{
    public function index()
    {
        
    }
    public function parcelas()
    {
        $this->content('relatorios/parcelas');
    }
}
<?php

namespace App\Controller;

use System\Core\Controller;

use App\Storage\Terrenos;
use App\Storage\Quadras;
use App\Storage\Lotes;
use App\Storage\Pessoas;
use App\Storage\Contratos;

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $join = 'INNER JOIN terrenos ON (terrenos.id = quadras.terrenos_id)';
        $data['lotes'] = Lotes::all(['select'=>'lotes.*, quadras.descricao as quadra, terrenos.descricao as terreno',
                            'joins'=>['quadras', $join],
                            'limit'=>10,
                            'order'=>'id DESC']);
        $data['quadras_count'] = Quadras::count();
        $data['lotes_count'] = Lotes::count();
        $data['clientes_count'] = Pessoas::count(['conditions'=>['tipo = ?', 'cliente']]);
        $data['contratos_count'] = Contratos::count();
        $this->content('home/index', $data);
    }
}
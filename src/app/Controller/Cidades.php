<?php

namespace App\Controller;

use System\Core\Controller;
use App\Storage\Cidades as Model;

class Cidades extends Controller
{
    public function __construct()
    {
        Authentication::manager();
        parent::__construct();
    }

    public function cidades($estado)
    {
        $estado = filter_var($estado, FILTER_SANITIZE_NUMBER_INT);
        
        foreach (Model::all(['conditions'=>['estados_id = ?', $estado]]) as $cidade) {
            $data[] = ['id'=>$cidade->id, 'nome'=>$cidade->nome];
        }

        return $this->outputJSON($data);
    }
}
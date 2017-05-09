<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Parcelas as Model;
use App\Storage\Contratos;
use App\Storage\Pessoas;

class Parcelas extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function payment_card($id)
    {
        $this->data['contrato'] = Contratos::find($id);
        $this->data['data'] = Model::all(['conditions'=>['contratos_id = ?', $id]]);
        $this->view('contratos/payment_card', $this->data)->show();
    }
}
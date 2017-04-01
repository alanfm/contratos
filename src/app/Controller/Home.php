<?php

namespace App\Controller;

use System\Core\Controller;

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->content('home/index', ['clientes'=>'025']);
    }
}
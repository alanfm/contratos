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
        $this->view('template/header')->show();
        $this->view('template/menu')->show();
        $this->view('home/index')->show();
        $this->view('template/footer')->show();
    }
}
<?php

namespace App\Controller;

use System\Core\Controller;

class Error extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function error404()
    {
        $this->view('error/404')->show();
    }

    public function error401()
    {
        $this->content('error/401');
    }

    public function error403()
    {
        $this->content('error/403');
    }
}
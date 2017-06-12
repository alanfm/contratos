<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Usuarios;

class Authentication extends Controller
{
    public function index()
    {
        $this->view('autentication/index')->show();
    }

    public function login()
    {
        $usuario = Usuarios::find(['conditions'=>['email = ?', filter_input(INPUT_POST, 'email')]]);

        if (is_object($usuario) && password_verify(filter_input(INPUT_POST, 'senha'), $usuario->password)) {
            $_SESSION['user_id'] = $usuario->id;
            $_SESSION['user_nome'] = $usuario->usuario;
            $_SESSION['user_nivel'] = $usuario->nivel;
            $_SESSION['authenticated'] = md5($_SERVER['HTTP_USER_AGENT']);
            $_SESSION['limit_time'] = time();

            \ActiveRecord\MysqlAdapter::$datetime_format = 'Y-m-d H:i:s';
            $usuario->ultimo_acesso = date('Y-m-d H:i:s');
            $usuario->save();
        } else {
            $_SESSION['alert'] = ['message'=>'Erro ao efetuar o login!', 'error'=>'warning'];
        }

        Utilities::redirect('');
    }

    public function logout()
    {
        if (isset($_SESSION['authenticated'])) {
            session_destroy();
        }

        Utilities::redirect('autenticacao');
    }

    public static function verify($level = null)
    {        
        if (empty($_SESSION['authenticated'])) {
            Utilities::redirect('autenticacao/');
        }

        if (isset($_SESSION) && $_SESSION['authenticated'] !== md5($_SERVER['HTTP_USER_AGENT'])) {
            Utilities::redirect('autenticacao/sair/');
        }

        if ((time() - $_SESSION['limit_time']) > (60 * 60)) {         
            Utilities::redirect('autenticacao/sair/');
        } else {
            $_SESSION['limit_time'] = time();
        }
    }

    public static function is_admin()
    {
        return $_SESSION['user_nivel'] === 'admin';
    }

    public static function is_manager()
    {
        return $_SESSION['user_nivel'] === 'manager';
    }

    public static function is_salesman()
    {
        return $_SESSION['user_nivel'] === 'salesman';
    }
}


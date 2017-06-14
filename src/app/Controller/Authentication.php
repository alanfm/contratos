<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;

use \ActiveRecord\MysqlAdapter;

use App\Storage\Usuarios;
use App\Storage\Sessoes;

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
            if (!$usuario->status) {
                $_SESSION['alert'] = ['message'=>'Usuário desativado! Por favor entre em contato com o administrador.', 'error'=>'warning'];
                Utilities::redirect('');
                exit();
            }

            $_SESSION['user_id'] = $usuario->id;
            $_SESSION['user_nome'] = $usuario->usuario;
            $_SESSION['authenticated'] = md5($_SERVER['HTTP_USER_AGENT']);
            $_SESSION['limit_time'] = time();

            $usuario->ultimo_acesso = date('Y-m-d H:i:s');
            $usuario->save();

            Sessoes::create(['inicio'=>date('Y-m-d H:i:s'), 'usuarios_id'=>$usuario->id]);
            $_SESSION['user_session'] = Sessoes::find('last')->id;
        } else {
            $_SESSION['alert'] = ['message'=>'E-mail ou senha incorretos!', 'error'=>'danger'];
        }

        Utilities::redirect('');
    }

    public function logout()
    {
        if (isset($_SESSION['authenticated'])) {
            Sessoes::find($_SESSION['user_session'])->update_attributes(['final'=>date('Y-m-d H:i:s')]);
            session_destroy();
        }

        Utilities::redirect('autenticacao');
    }

    public static function verify()
    {        
        if (empty($_SESSION['authenticated'])) {
            Utilities::redirect('autenticacao/');
        }

        if (isset($_SESSION) && ($_SESSION['authenticated'] !== md5($_SERVER['HTTP_USER_AGENT']))) {
            Utilities::redirect('autenticacao/sair/');
        }

        if ((time() - $_SESSION['limit_time']) > (60 * 60)) {         
            Utilities::redirect('autenticacao/sair/');
        } else {
            $_SESSION['limit_time'] = time();
        }
    }

    public static function admin()
    {
        self::verify();
        if (Usuarios::find($_SESSION['user_id'])->nivel != 'admin') {
            Utilities::redirect('erro/401');
        }
    }

    public static function manager()
    {
        self::verify();
        if ((Usuarios::find($_SESSION['user_id'])->nivel !== 'admin') && (Usuarios::find($_SESSION['user_id'])->nivel !== 'manager')) {
            Utilities::redirect('erro/401');
        }
    }

    public static function salesman()
    {
        self::verify();
        if ((Usuarios::find($_SESSION['user_id'])->nivel !== 'admin') && (Usuarios::find($_SESSION['user_id'])->nivel !== 'manager') && (Usuarios::find($_SESSION['user_id'])->nivel !== 'salesman')) {
            Utilities::redirect('erro/401');
        }
    }

    public static function is_admin()
    {
        return Usuarios::find($_SESSION['user_id'])->nivel == 'admin';
    }

    public static function is_manager()
    {
        return Usuarios::find($_SESSION['user_id'])->nivel == 'admin' || Usuarios::find($_SESSION['user_id'])->nivel == 'manager';
    }

    public static function is_salesman()
    {
        return Usuarios::find($_SESSION['user_id'])->nivel == 'admin' || Usuarios::find($_SESSION['user_id'])->nivel == 'manager' || Usuarios::find($_SESSION['user_id'])->nivel == 'salesman';
    }
}


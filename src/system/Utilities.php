<?php

namespace System;

class Utilities
{
    public static function token()
    {
        if (!isset($_SESSION['token'])) {        
            $_SESSION['token'] = md5(uniqid(rand(), true));
        }
        
        return $_SESSION['token'];
    }

    /**
     * @method redirect()
     * @access public
     * 
     * Redireciona para a pagina passada por paramentro
     * 
     * @param string
     */
    public static function redirect($url)
    {
        header('Location: ' . URL_BASE . $url);
        exit();
    }
}
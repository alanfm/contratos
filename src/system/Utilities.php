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

    public static function mask($val, $mask)
    {
        $val = (string) $val;
        $maskared = '';
        $k = 0;
        for($i = 0; $i <= strlen($mask) - 1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if(isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }

        return $maskared;
    }
}
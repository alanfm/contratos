<?php
mb_internal_encoding('UTF-8');
date_default_timezone_set('America/Fortaleza');
/**
 * Carregamento automatico das classes
 */
$autoload = __DIR__ . '/vendor/autoload.php';

if (!file_exists($autoload)) {
    echo "Você precisa instalar os componentes com o comando <strong>composer install</strong>!";
    exit;
}

require_once $autoload;

/**
 * Configuração das sessões
 */
ini_set('session.cookie_httponly', 1);
session_cache_expire(60); // Expira em 60 minutos
session_name(md5('SGCP'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

/**
 * Arquivos de configuração
 */
require_once __DIR__ . '/src/app/config.php';

/**
 * Rotas do sistema
 */

$router = new Gears\Router();
$router->routesPath = __DIR__ . '/src/app/Router';
$router->exitOnComplete = true;
/**
 * Cria um cache da página de erro!
 */
ob_start();
    (new \App\Controller\Error())->error404();
    $error404 = ob_get_contents();
ob_end_clean();
$router->notFound = $error404;

$router->dispatch();
<?php

/**
 * Constantes usadas pelo sistema
 */

/**
 * Esse bloco de constantes só deve ser mudado se
 * você tiver certeza do que estará fazendo,
 * pois o mesmo define os diretorio para o MVC
 */
define('VIEW_DIR', __DIR__ . '/View/');
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);

/**
 * Modifique para a URL do seu sistema
 */
define('URL_BASE','http://contratos.dev/');

/**
 * Configurações para conexão com o banco de dados
 */
define('DB_HOST', 'localhost'); // Host onde está o banco de dados
define('DB_DBMS', 'mysql');		// Sistema de Gerenciamento de Banco de Dados
define('DB_NAME', 'contratos');		// Nome do banco de dados
define('DB_USER', 'root');		// Usuário do banco de dados
define('DB_PASS', '');		// Senha do usuário do banco de dados

/**
 * Configurações do ActiveRecordo PHP
 */
\ActiveRecord\Config::initialize(function($cfg) {
    $cfg->set_connections(array('development' =>
                                sprintf('mysql://%s:%s@%s/%s', DB_USER, DB_PASS, DB_HOST, DB_NAME)));
});
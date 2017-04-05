<?php

use App\Controller\Clientes;

Route::group(['prefix' => 'clientes'], function() {
    Route::get('/', function() {
        (new Clientes())->index();
    });

    Route::post('/', function() {
        (new Clientes())->create();
    });

    Route::get('/editar/{id}', function($id) {
        (new Clientes())->edit($id);
    });

    Route::post('/editar/{id}', function($id) {
        (new Clientes())->update($id);
    });

    Route::get('/apagar/{id}', function($id) {
        (new Clientes())->delete($id);
    });

    Route::post('/pesquisar', function() {
        (new Clientes())->search();
    });

    Route::get('/pagina/{page}', function($page) {
        (new Clientes())->pagination($page);
    });
});
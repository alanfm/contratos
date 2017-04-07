<?php

use App\Controller\Telefones;

Route::group(['prefix' => 'clientes/telefones'], function() {
    Route::get('/{cliente}', function($cliente) {
        (new Telefones())->index($cliente);
    });

    Route::post('/{cliente}', function($cliente) {
        (new Telefones())->create($cliente);
    });

    Route::get('/editar/{cliente}/{id}', function($cliente, $id) {
        (new Telefones())->edit($cliente, $id);
    });

    Route::post('/editar/{cliente}/{id}', function($cliente, $id) {
        (new Telefones())->update($cliente, $id);
    });

    Route::get('/apagar/{id}', function($cliente, $id) {
        (new Telefones())->delete($cliente, $id);
    });

    Route::post('/pesquisar/{cliente}', function($cliente) {
        (new Telefones())->search($cliente);
    });

    Route::get('/detalhes/{cliente}/{id}', function($cliente, $id) {
        (new Telefones())->details($cliente, $id);
    });

    Route::get('/pagina/{cliente}/{page}', function($cliente, $page) {
        (new Telefones())->pagination($cliente, $page);
    });
});
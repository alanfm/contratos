<?php

use App\Controller\Contratos;

Route::group(['prefix' => 'contratos'], function() {
    Route::get('/{cliente}', function($cliente) {
        (new Contratos())->index($cliente);
    });

    Route::post('/{cliente}', function($cliente) {
        (new Contratos())->create($cliente);
    });

    Route::get('/editar/{cliente}/{id}', function($cliente, $id) {
        (new Contratos())->edit($cliente, $id);
    });

    Route::post('/editar/{cliente}/{id}', function($cliente, $id) {
        (new Contratos())->update($cliente, $id);
    });

    Route::get('/apagar/{id}', function($cliente, $id) {
        (new Contratos())->delete($cliente, $id);
    });

    Route::post('/pesquisar/{cliente}', function($cliente) {
        (new Contratos())->search($cliente);
    });

    Route::get('/detalhes/{id}', function($id) {
        (new Contratos())->details($id);
    });

    Route::get('/pagina/{cliente}/{page}', function($cliente, $page) {
        (new Contratos())->pagination($cliente, $page);
    });
});
<?php

use App\Controller\Contratos;

Route::group(['prefix' => 'contratos'], function() {
    Route::get('/{cliente}', function($cliente) {
        (new Contratos())->index($cliente);
    });

    Route::post('/{cliente}', function($cliente) {
        (new Contratos())->create($cliente);
    });

    Route::get('/imprimir/{id}', function($id) {
        (new Contratos())->impress($id);
    });

    Route::get('/editar/{cliente}/{id}', function($cliente, $id) {
        (new Contratos())->edit($cliente, $id);
    });

    Route::post('/editar/{cliente}/{id}', function($cliente, $id) {
        (new Contratos())->update($cliente, $id);
    });

    Route::get('/cancelar/{cliente}/{id}/{page}', function($cliente, $id, $page) {
        (new Contratos())->cancel($cliente, $id, $page);
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

    Route::get('/extrato/{id}', function($id) {
        (new Contratos())->extract($id);
    });
});
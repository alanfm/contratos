<?php

use App\Controller\Cidades;
use App\Controller\Estados;
use App\Controller\Enderecos;

Route::group(['prefix' => 'enderecos'], function() {
    Route::get('/cidades/{estado}', function($estado) {
        (new Cidades())->cidades($estado);
    });
});

Route::group(['prefix' => 'clientes/enderecos'], function() {
    Route::get('/{cliente}', function($cliente) {
        (new Enderecos())->index($cliente);
    });

    Route::post('/{cliente}', function($cliente) {
        (new Enderecos())->create($cliente);
    });

    Route::get('/editar/{cliente}/{id}', function($cliente, $id) {
        (new Enderecos())->edit($cliente, $id);
    });

    Route::post('/editar/{cliente}/{id}', function($cliente, $id) {
        (new Enderecos())->update($cliente, $id);
    });

    Route::get('/apagar/{id}', function($cliente, $id) {
        (new Enderecos())->delete($cliente, $id);
    });

    Route::post('/pesquisar/{cliente}', function($cliente) {
        (new Enderecos())->search($cliente);
    });

    Route::get('/detalhes/{cliente}/{id}', function($cliente, $id) {
        (new Enderecos())->details($cliente, $id);
    });

    Route::get('/pagina/{cliente}/{page}', function($cliente, $page) {
        (new Enderecos())->pagination($cliente, $page);
    });
});
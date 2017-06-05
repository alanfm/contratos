<?php

use App\Controller\Relatorios;

Route::group(['prefix' => 'relatorios'], function() {
    Route::get('/parcelas', function() {
        (new Relatorios())->parcelas();
    });

    Route::get('/clientes', function() {
        (new Relatorios())->clientes();
    });

    Route::get('/contratos', function() {
        (new Relatorios())->contratos();
    });
});
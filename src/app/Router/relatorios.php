<?php

use App\Controller\Relatorios;

Route::group(['prefix' => 'relatorios'], function() {
    Route::get('/parcelas', function() {
        (new Relatorios())->parcelas();
    });

    Route::get('/parcelas/data', function() {
        (new Relatorios())->parcelas_date();
    });

    Route::post('/parcelas/data', function() {
        (new Relatorios())->parcelas_date();
    });

    Route::get('/clientes', function() {
        (new Relatorios())->clientes();
    });

    Route::get('/contratos', function() {
        (new Relatorios())->contratos();
    });

    Route::get('/usuarios', function() {
        (new Relatorios())->usuarios();
    });
});
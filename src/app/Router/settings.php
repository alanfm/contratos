<?php

use App\Controller\Settings;

Route::group(['prefix' => 'configuracoes'], function() {
    Route::get('/', function() {
        (new Settings())->index();
    });

    Route::post('/', function() {
        (new Settings())->vendedor();
    });

    Route::post('/conta', function() {
        (new Settings())->conta();
    });

    Route::post('/empresa', function() {
        (new Settings())->empresa();
    });

    Route::post('/endereco', function() {
        (new Settings())->endereco();
    });

    Route::post('/telefone', function() {
        (new Settings())->telefone();
    });
});
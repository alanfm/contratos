<?php
use App\Controller\Authentication;

Route::group(['prefix' => 'autenticacao'], function() {
    Route::get('/', function() {
        (new Authentication())->index();
    });

    Route::post('/entrar', function() {
        (new Authentication())->login();
    });

    Route::get('/sair', function() {
        (new Authentication())->logout();
    });
});
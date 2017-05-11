<?php

use App\Controller\Parcelas;

Route::group(['prefix' => 'parcelas'], function() {
    Route::get('/editar/{id}', function($id) {
        (new Parcelas())->edit($id);
    });

    Route::post('/editar/{id}', function($id) {
        (new Parcelas())->update($id);
    });

    Route::get('/carne/{id}', function($id) {
        (new Parcelas())->payment_card($id);
    });

    Route::post('/pagamento', function() {
        (new Parcelas())->payment();
    });    

    Route::get('/cancelar/{id}/{token}', function($id, $token) {
        (new Parcelas())->cancel($id, $token);
    });
});
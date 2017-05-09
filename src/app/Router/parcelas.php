<?php

use App\Controller\Parcelas;

Route::group(['prefix' => 'parcelas'], function() {
    Route::get('/carne/{id}', function($id) {
        (new Parcelas())->payment_card($id);
    });
});
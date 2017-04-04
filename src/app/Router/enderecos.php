<?php

use App\Controller\Cidades;
use App\Controller\Estados;

Route::group(['prefix' => 'enderecos'], function() {
    Route::get('/cidades/{estado}', function($estado) {
        (new Cidades())->cidades($estado);
    });
});
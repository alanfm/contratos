<?php

use App\Controller\Quadras;

Route::group(['prefix' => 'terrenos'], function() {
    Route::get('/quadras', function() {
        (new Quadras())->index();
    });

    Route::post('/quadras', function() {
        (new Quadras())->create();
    });

    Route::get('/quadras/editar/{id}', function($id) {
        (new Quadras())->edit($id);
    });

    Route::post('/quadras/editar/{id}', function($id) {
        (new Quadras())->update($id);
    });

    Route::get('/quadras/apagar/{id}', function($id) {
        (new Quadras())->delete($id);
    });

    Route::post('/quadras/pesquisar', function() {
        (new Quadras())->search();
    });

    Route::get('/quadras/pagina/{page}', function($page) {
        (new Quadras())->pagination($page);
    });
});
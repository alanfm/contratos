<?php

use App\Controller\Terrenos;

Route::group(['prefix' => 'terrenos'], function() {
    Route::get('/', function() {
        (new Terrenos())->index();
    });

    Route::post('/', function() {
        (new Terrenos())->create();
    });

    Route::get('/editar/{id}', function($id) {
        (new Terrenos())->edit($id);
    });

    Route::post('/editar/{id}', function($id) {
        (new Terrenos())->update($id);
    });

    Route::get('/apagar/{id}', function($id) {
        (new Terrenos())->delete($id);
    });

    Route::post('/pesquisar', function() {
        (new Terrenos())->search();
    });

    Route::get('/pagina/{page}', function($page) {
        (new Terrenos())->pagination($page);
    });
});
<?php

use App\Controller\Usuarios;

Route::group(['prefix' => 'usuarios'], function() {
    Route::get('/', function() {
        (new Usuarios())->index();
    });

    Route::post('/', function() {
        (new Usuarios())->create();
    });

    Route::get('/editar/{id}', function($id) {
        (new Usuarios())->edit($id);
    });

    Route::post('/editar/{id}', function($id) {
        (new Usuarios())->update($id);
    });

    Route::get('/apagar/{id}', function($id) {
        (new Usuarios())->delete($id);
    });

    Route::post('/pesquisar', function() {
        (new Usuarios())->search();
    });

    Route::get('/pagina/{page}', function($page) {
        (new Usuarios())->pagination($page);
    });
});
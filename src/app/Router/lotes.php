<?php

use App\Controller\Lotes;

Route::group(['prefix' => 'terrenos'], function() {
    Route::get('/lotes', function() {
        (new Lotes())->index();
    });

    Route::post('/lotes', function() {
        (new Lotes())->create();
    });

    Route::get('/lotes/editar/{id}', function($id) {
        (new Lotes())->edit($id);
    });

    Route::post('/lotes/editar/{id}', function($id) {
        (new Lotes())->update($id);
    });

    Route::get('/lotes/apagar/{id}', function($id) {
        (new Lotes())->delete($id);
    });

    Route::post('/lotes/pesquisar', function() {
        (new Lotes())->search();
    });

    Route::get('/lotes/pagina/{page}', function($page) {
        (new Lotes())->pagination($page);
    });

    Route::get('/lotes/{quadra}', function($quadra) {
        (new Lotes())->lotes_by_quadra($quadra);
    });
});
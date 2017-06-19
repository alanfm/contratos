<?php

use App\Controller\Error;

Route::group(['prefix' => 'erro'], function() {
    Route::get('/403', function() {
        (new Error())->error403();
    });

    Route::get('/404', function() {
        (new Error())->error404();
    });

    Route::get('/401', function() {
        (new Error())->error401();
    });
});
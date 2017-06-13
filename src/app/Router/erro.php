<?php

use App\Controller\Error;

Route::group(['prefix' => 'erro'], function() {
    Route::get('/404', function() {
        (new Error())->error404();
    });

    Route::get('/401', function() {
        (new Error())->error401();
    });
});
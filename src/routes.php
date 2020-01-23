<?php

/**
 *
 */
if (env('SMARTDETECT_DEBUG_MODE', env('APP_DEBUG', false))) {
    Route::group(['prefix' => '/smartdetect', 'namespace' => 'Lotfixyz\Smartdetect'], function () {
        Route::any('/test/{result_type?}', 'SmartdetectController@test');
    });
}


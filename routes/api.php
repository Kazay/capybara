<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::namespace('Api\Users')->group(function() {
        Route::get('/users',        "UsersController@index");
        Route::get('/users/{user}', "UsersController@show");

        Route::middleware('role:admin')->group(function() {
            Route::put('/users/ban/{user}', "UsersController@ban");
        });
    });

    Route::namespace('Api\Production')->group(function() {
        Route::get('/troupes',          'TroupesController@index');
        Route::get('/troupes/{troupe}', 'TroupesController@show');

        Route::get('/directors',            'DirectorsController@index');
        Route::get('/directors/{director}', 'DirectorsController@show');

        Route::middleware('role:admin')->group(function() {
            Route::post     ('/troupes',          'TroupesController@store');
            Route::put      ('/troupes/{troupe}', 'TroupesController@update');
            Route::delete   ('/troupes/{troupe}', 'TroupesController@destroy');

            Route::post     ('/directors',              'DirectorsController@store');
            Route::put      ('/directors/{director}',   'DirectorsController@update');
            Route::delete   ('/directors/{director}',   'DirectorsController@destroy');
        });
    });
});

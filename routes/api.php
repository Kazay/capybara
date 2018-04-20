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

    Route::namespace('Api')->group(function () {
        // public users
        Route::get('/users',                "UsersController@index");
        Route::get('/users/{user}',         "UsersController@show");
        Route::get('/users/{user}/tickets', "UsersController@ticketing");

        // Plays public
        Route::get('/plays',        'PlaysController@index');
        Route::get('/plays/{play}', 'PlaysController@show');

        // Performances public
        Route::get('/performances',                             'PerformancesController@index');
        Route::get('/performances/{performance}',               'PerformancesController@show');
        Route::put('/performances/{performance}/subscribe',     'PerformancesController@subscribe');
        Route::put('/performances/{performance}/unsubscribe',   'PerformancesController@unsubscribe');

        Route::middleware('role:admin')->group(function () {
            // Users admin
            Route::put('/users/ban/{user}', "UsersController@ban");

            // Plays admin
            Route::post  ('/plays',         'PlaysController@store');
            Route::put   ('/plays/{play}',  'PlaysController@update');
            Route::delete('/plays/{play}',  'PlaysController@destroy');

            // Performances Admin
            Route::post  ('/performances',                  'PerformancesController@store');
            Route::put   ('/performances/{performance}',    'PerformancesController@update');
            Route::delete('/performances/{performance}',    'PerformancesController@destroy');
        });
    

        Route::namespace('Production')->group(function () {
            // Troupes public
            Route::get('/troupes',                  'TroupesController@index');
            Route::get('/troupes/{troupe}',         'TroupesController@show');
            Route::get('/troupes/{troupe}/plays',   'TroupesController@showPlays');

            // Directors public
            Route::get('/directors',                    'DirectorsController@index');
            Route::get('/directors/{director}',         'DirectorsController@show');
            Route::get('/directors/{director}/plays',   'DirectorsController@showPlays');

            Route::middleware('role:admin')->group(function () {
                // troupes admin
                Route::post('/troupes',                 'TroupesController@store');
                Route::put('/troupes/{troupe}',         'TroupesController@update');
                Route::delete('/troupes/{troupe}',      'TroupesController@destroy');

                // directors admin
                Route::post('/directors',               'DirectorsController@store');
                Route::put('/directors/{director}',     'DirectorsController@update');
                Route::delete('/directors/{director}',  'DirectorsController@destroy');
            });
        });
    });
});

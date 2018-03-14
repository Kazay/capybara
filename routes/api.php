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
        Route::get('/users', "UsersPublicController@showUsers")->name('userList');
        Route::get('/users/{id}', "UsersPublicController@showUser");

        Route::middleware('role:admin')->group(function() {
            Route::put('/users/ban/{id}', "UsersAdminController@banUser");
            Route::put('/users/unban/{id}', "UsersAdminController@unbanUser");
        });
    });
});

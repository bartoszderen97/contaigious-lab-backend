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
Route::middleware('cors')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', 'API\AuthController@login');
        Route::post('register', 'API\AuthController@register');
        Route::post('resetPassword', 'API\AuthController@resetPassword')->name('password.reset');
    });

    Route::prefix('examination')->group(function () {
        Route::get('get', 'API\ExaminationsController@getExamination');
        Route::get('getByName/{name}', 'API\ExaminationsController@getExaminationByName');
        Route::post('add', 'API\ExaminationsController@addExamination');
        Route::put('edit', 'API\ExaminationsController@editExamination');
        Route::delete('get', 'API\ExaminationsController@deleteExamination');
    });

});

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


    Route::get('/token-expired', function() {
        return response()->json([
            'status' => \Illuminate\Http\Response::HTTP_UNAUTHORIZED,
            'message' => __('Token expired. Please login')
        ]);
    })->name('login');


    Route::middleware('auth:api')->prefix('user')->group(function () {
        Route::get('getAll', 'API\UserController@getAllUsers');
        Route::get('getByName/{name}', 'API\UserController@getUserByName');
        Route::get('getSingle/{id_user}', 'API\UserController@getSingleUser');
        Route::delete('delete/{id_user}', 'API\UserController@deleteUser');
        Route::put('update', 'API\UserController@updateUser');
    });

    Route::prefix('examination')->group(function () {
        Route::get('get', 'API\ExaminationsController@getExamination');
        Route::get('getAll', 'API\ExaminationsController@getAllExamination');
        Route::get('getByName/{name}', 'API\ExaminationsController@getExaminationByName');
        Route::middleware('auth:api')->post('add', 'API\ExaminationsController@addExamination');
        Route::middleware('auth:api')->put('edit', 'API\ExaminationsController@editExamination');
        Route::middleware('auth:api')->delete('delete', 'API\ExaminationsController@deleteExamination');
    });

    Route::middleware('auth:api')->prefix('application')->group(function () {
        Route::get('getAll', 'API\ApplicationController@getAllApplications');
        Route::get('getAllUser', 'API\ApplicationController@getAllApplicationsOfUser');
        Route::get('getSingle/{id_application}', 'API\ApplicationController@getSingleApplication');
        Route::delete('delete/{id_application}', 'API\ApplicationController@deleteApplication');
        Route::put('update', 'API\ApplicationController@updateApplication');
        Route::post('create', 'API\ApplicationController@createApplication');
    });

    Route::middleware('auth:api')->prefix('result')->group(function () {
        Route::get('getAll', 'API\ResultsController@getAllResults');
        Route::get('getAllUser', 'API\ResultsController@getAllResultsOfUser');
        Route::get('getSingle/{id_application}', 'API\ResultsController@getSingleResult');
        Route::delete('delete/{id_result}', 'API\ResultsController@deleteResult');
        Route::put('update', 'API\ResultsController@updateResult');
        Route::post('create', 'API\ResultsController@createResult');
    });

});

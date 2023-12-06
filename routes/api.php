<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers\API'], function () {
    Route::post('login', 'AuthController@login')->name('login');

    Route::group(['middleware' => ['auth:sanctum']],function () {
        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', 'Employee\EmployeeController@index')->name('employee.index');
            Route::post('/store', 'Employee\EmployeeController@store')->name('employee.store');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::post('/store', 'User\UserController@store')->name('user.store');
            Route::get('/', 'User\UserController@index')->name('user.index');
            Route::get('/{id}', 'User\UserController@show')->name('user.show');
        });
    });
});

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

    Route::group(['middleware' => 'auth:sanctum'],function () {
        Route::post('logout', 'AuthController@logout')->name('logout');

        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', 'Employee\EmployeeController@index')->name('employee.index');
            Route::get('/show', 'Employee\EmployeeController@show')->name('employee.show');
            Route::post('/store', 'Employee\EmployeeController@store')->name('employee.store');
            Route::put('/update', 'Employee\EmployeeController@update')->name('employee.update');
            Route::delete('/delete', 'Employee\EmployeeController@delete')->name('employee.delete');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::post('/store', 'User\UserController@store')->name('user.store');
            Route::get('/', 'User\UserController@index')->name('user.index');
            Route::get('/show', 'User\UserController@show')->name('user.show');
            Route::put('/update', 'User\UserController@update')->name('user.update');
        });

        Route::group(['prefix' => 'positions'], function () {
            Route::group(['prefix' => 'job-title'], function () {
                Route::get('/', 'Position\JobTitleController@index')->name('job-title.index');
                Route::post('/store', 'Position\JobTitleController@store')->name('job-title.store');
                Route::put('/update', 'Position\JobTitleController@update')->name('job-title.update');
                Route::get('/show', 'Position\JobTitleController@show')->name('job-title.show');
            });
        });
    });
});

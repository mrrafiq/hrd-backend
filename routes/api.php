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
    Route::get('/', 'TestController@test')->name('test');
    Route::post('login', 'AuthController@login')->name('login');

    Route::group(['middleware' => 'auth:sanctum'],function () {
        Route::post('logout', 'AuthController@logout')->name('logout');
        Route::get('/me', 'AuthController@me')->name('me');
        Route::get('/show-permissions', 'AuthController@showUserPermissions')->name('user.show-permissions');

        Route::group(['prefix' => 'employee', 'middleware' => ['permission:browse_employee|read_employee|edit_employee|delete_employee|add_employee']], function () {
            Route::get('/', 'Employee\EmployeeController@index')->name('employee.index');
            Route::get('/show', 'Employee\EmployeeController@show')->name('employee.show');
            Route::post('/store', 'Employee\EmployeeController@store')->name('employee.store');
            Route::put('/update', 'Employee\EmployeeController@update')->name('employee.update');
            Route::delete('/delete', 'Employee\EmployeeController@delete')->name('employee.delete');

            Route::group(['prefix' => 'contacts'], function(){
                Route::get('/', 'Employee\ContactsController@index')->name('employee.contacts.index');
                Route::get('/show', 'Employee\ContactsController@show')->name('employee.contacts.show');
                Route::post('/store', 'Employee\ContactsController@store')->name('employee.contacts.store');
                Route::put('/update', 'Employee\ContactsController@update')->name('employee.contacts.update');
                Route::delete('/delete', 'Employee\ContactsController@delete')->name('employee.contacts.delete');
            });

            Route::group(['prefix' => 'work_experiences'], function(){
                Route::get('/', 'Employee\WorkExperienceController@index')->name('employee.work_experience.index');
                Route::get('/show', 'Employee\WorkExperienceController@show')->name('employee.work_experience.show');
                Route::post('/store', 'Employee\WorkExperienceController@store')->name('employee.work_experience.store');
                Route::put('/update', 'Employee\WorkExperienceController@update')->name('employee.work_experience.update');
                Route::delete('/delete', 'Employee\WorkExperienceController@delete')->name('employee.work_experience.delete');
            });

            Route::group(['prefix' => 'educations'], function(){
                Route::get('/', 'Employee\EducationController@index')->name('employee.education.index');
                Route::get('/show', 'Employee\EducationController@show')->name('employee.education.show');
                Route::post('/store', 'Employee\EducationController@store')->name('employee.education.store');
                Route::put('/update', 'Employee\EducationController@update')->name('employee.education.update');
                Route::delete('/delete', 'Employee\EducationController@delete')->name('employee.education.delete');
            });
        });

        Route::group(['prefix' => 'user', 'middleware' => ['permission:browse_user|read_user|edit_user|delete_user|add_user']], function () {
            Route::post('/store', 'User\UserController@store')->name('user.store');
            Route::get('/', 'User\UserController@index')->name('user.index');
            Route::get('/show', 'User\UserController@show')->name('user.show');
            Route::put('/update', 'User\UserController@update')->name('user.update');
            Route::post('/assign_role', 'User\UserController@assign_role')->name('user.assign_role');
        });

        Route::group(['prefix' => 'positions', 'middleware' => ['permission:browse_positions|read_positions|edit_positions|delete_positions|add_positions']], function () {
            Route::group(['prefix' => 'job-title'], function () {
                Route::get('/', 'Position\JobTitleController@index')->name('job-title.index');
                Route::post('/store', 'Position\JobTitleController@store')->name('job-title.store');
                Route::put('/update', 'Position\JobTitleController@update')->name('job-title.update');
                Route::get('/show', 'Position\JobTitleController@show')->name('job-title.show');
                Route::delete('/delete', 'Position\JobTitleController@delete')->name('job-title.delete');
            });
        });

        Route::group(['prefix' => 'roles', 'middleware' => ['permission:browse_roles|read_roles|edit_roles|delete_roles|add_roles']], function () {
            Route::get('/', 'User\RoleController@index')->name('role.index');
            Route::post('/store', 'User\RoleController@store')->name('role.store');
            Route::post('/assign-permissions', 'User\RoleController@assignPermission')->name('role.assign-permissions');
            Route::put('/update', 'User\RoleController@update')->name('role.update');
            Route::get('/show', 'User\RoleController@show')->name('role.show');
            Route::get('/show-permissions', 'User\RoleController@showPermissions')->name('role.show-permissions');
            Route::delete('/delete', 'User\RoleController@destroy')->name('role.destroy');
        });

        Route::group(['prefix' => 'permissions', 'middleware' => ['permission:browse_permissions|read_permissions|edit_permissions|delete_permissions|add_permissions']], function () {
            Route::get('/', 'User\PermissionController@index')->name('permission.index');
            Route::post('/store', 'User\PermissionController@store')->name('permission.store');
            Route::put('/update', 'User\PermissionController@update')->name('permission.update');
            Route::get('/show', 'User\PermissionController@show')->name('permission.show');
            Route::get('/show-roles', 'User\PermissionController@showRole')->name('permission.show-roles');
            Route::delete('/delete', 'User\PermissionController@destroy')->name('permission.delete');
            Route::post('/assign-roles', 'User\PermissionController@assignRolesToPermision')->name('permission.assignRolesToPermission');
        });

        Route::group(['prefix' => 'department', 'middleware' => ['permission:browse_department|read_department|edit_department|delete_department|add_department']], function () {
            Route::get('/', 'Position\DepartmentController@index')->name('department.index');
            Route::post('/store', 'Position\DepartmentController@store')->name('department.store');
            Route::put('/update', 'Position\DepartmentController@update')->name('department.update');
            Route::get('/show', 'Position\DepartmentController@show')->name('department.show');
            Route::delete('/delete', 'Position\DepartmentController@delete')->name('department.delete');
        });
    });
});

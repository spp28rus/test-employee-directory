<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => 'v1',
    'as' => 'api.v1.',
], function () {

    Route::get('/employee-public-info', 'Api\V1\EmployeePublicInfoController@index')
        ->name('employee_public_info.index');

    Route::group([
        'middleware' => 'auth:api',
    ], function () {

        Route::resource('employee', 'Api\V1\EmployeeController')
        ->only([
            'index',
            'show',
            'destroy',
        ]);

        Route::patch('/user-role/{user}/is-admin', 'Api\V1\UserRoleController@updateIsAdmin')
            ->name('user_role.is_admin.update');

        Route::resource('post', 'Api\V1\PostController')
            ->only([
                'index',
                'store',
                'show',
                'update',
                'destroy',
            ]);

        Route::resource('skill', 'Api\V1\SkillController')
            ->only([
                'index',
                'store',
                'show',
                'update',
                'destroy',
            ]);

        Route::patch('/employee-post/{employee}/update', 'Api\V1\EmployeePostController@update')
            ->name('employee_post.update');

        Route::patch('/employee-skills/{employee}/update', 'Api\V1\EmployeeSkillController@update')
            ->name('employee_skill.update');

    });
});


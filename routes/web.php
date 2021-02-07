<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')
    ->name('home');

Route::get('/employee-public-info', 'EmployeePublicInfoController@index');

Route::resource('employee', 'EmployeeController')
    ->only([
        'index',
        'show',
        'destroy',
    ])
    ->middleware('auth');

Route::resource('post', 'PostController')
    ->only([
        'index',
        'store',
        'show',
        'update',
        'destroy',
    ])
    ->middleware('auth');
Route::resource('skill', 'SkillController')
    ->only([
        'index',
        'store',
        'show',
        'update',
        'destroy',
    ])
    ->middleware('auth');

Route::patch('/user-role/{user}/is-admin', 'UserRoleController@updateIsAdmin')
    ->middleware('auth');

Route::get('/posts', 'PostsPageController@index')
    ->name('posts')
    ->middleware('auth');

Route::get('/skills', 'SkillsPageController@index')
    ->name('skills')
    ->middleware('auth');

Route::get('/employee-editor/{employee}', 'EmployeePageController@index')
    ->middleware('auth');

Route::patch('/employee-post/{employee}/update/{post}', 'EmployeePostController@update')
    ->middleware('auth');

Route::patch('/employee-skills/{employee}/update', 'EmployeeSkillController@update')
    ->middleware('auth');
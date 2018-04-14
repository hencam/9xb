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

use App\Employees;
use App\Roles;

Auth::routes();

// no registering of new accounts
Route::get('/register', 'HomeController@index')->name('home');

// protect list view with auth
Route::get('/', 'EmployeeController@index')->middleware('auth');

// employee CRUD handler
Route::resource('employees','EmployeeController')->middleware('auth');

// role CRUD handler
Route::resource('roles','RoleController')->middleware('auth');
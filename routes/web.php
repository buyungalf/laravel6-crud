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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('employee', 'EmployeeController')->middleware('auth');
Route::resource('karyawan', 'EmployeeAjaxController')->middleware('auth');
Route::get('/export-excel', 'EmployeeController@export')->middleware('auth')->name('export.excel');
Route::get('/export-pdf', 'EmployeeController@export_pdf')->middleware('auth')->name('export.pdf');

Route::get('/verify', 'Auth\RegisterController@verification')->name('verification');
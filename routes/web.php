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

use App\Exports\DataExport;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false, 'reset' => false]);


Route::resource('data', DataController::class)->except('show');
Route::get('/data/getData', 'DataController@getData')->name('data.getData');
Route::get('province/{province}/regencies', 'ProvinceController@regencies');
Route::get('regency/{regency}/districts', 'RegencyController@districts');
Route::get('export-csv', 'DataController@export_csv');
Route::get('export-pdf', 'DataController@export_pdf');

Route::resource('user', UserController::class)->except('show');
Route::get('/user/{user}/password', 'UserController@edit_password');
Route::put('/user/{user}/password', 'UserController@update_password');
Route::get('/user/{user}/logs', 'UserController@show');

Route::resource('log', LogController::class)->only('index');

Route::resource('import', ImportController::class);
Route::get('template', 'ImportController@template');

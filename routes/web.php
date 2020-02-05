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

Route::get('/backup', function () {


    return 'Successful backup!';

});    \Illuminate\Support\Facades\Artisan::call('backup:run');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/list/all', 'UserListController@index');

//Route::get('/users/list/all', function () {
//    (new App\Http\Controllers\UserListController)->index();
//});
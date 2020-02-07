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

// database backup route
Route::get('/backup', function () {

    \Illuminate\Support\Facades\Artisan::call('backup:run');

    return 'Successful backup!';
});


// datatable route
Route::get('/users/list/all', 'UserListController@index');

//Route::get('/users/list/all', function () {
//    (new App\Http\Controllers\UserListController)->index();
//});


// file uploader routes
Route::view('/upload', 'upload');

Route::post('/file/upload', 'PostController@upload');

Route::post('/store', 'PostController@store');


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
    return view('home');
})->name("home");

Route::get('/profiles', function () {
    return view('profiles');
})->name("profiles");

Route::get('/upload', function () {
    return view('upload');
})->name("uploadPayments");

Route::post('/profiles/create',"ProfilesController@submit")->name("profilesCreate");

Route::post('/upload/uploadFile',"UploadController@uploadFile")->name("uploadFile");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/upload/downloadFile', 'UploadController@getDownload')->name('downloadFile');

Route::get('/profiles_list', function () {
    return view('profiles_list');
})->name("profiles_list");

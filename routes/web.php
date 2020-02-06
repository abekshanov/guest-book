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

// на вывод сообщений на странице
Route::get('/pages/guest-book', 'GuestBookController@index')->name('guest-book')->middleware('auth');
//на обработчик данных формы
Route::post('/pages/send-msg', 'GuestBookController@formHandler')->name('send-msg')->middleware('auth');

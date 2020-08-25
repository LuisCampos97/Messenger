<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'PostController@listPosts')->name('home');

Route::get('/changePassword', 'Auth\ChangePassword@index')->name('changePassword');
Route::post('/changePassword', 'Auth\ChangePassword@changePassword')->name('changePassword');

Route::post('/createPost', 'PostController@createPost')->name('createPost');
Route::delete('/post/{post_id}', 'PostController@deletePost')->name('deletePost');


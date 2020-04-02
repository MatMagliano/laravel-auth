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

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/show/{slug}', 'PostController@show')->name('post.show');

Route::post('/store', 'CommentController@store')->name('comment.store');
Route::post('/comments/create', 'CommentController@store')->name('comments.store');

Route::name('admin.')
->prefix('admin')
->namespace('Admin')
->middleware('auth')
->group(function() {
    // Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('posts','PostController');
});

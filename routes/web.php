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

Route::get('/', ['uses' => 'HomeStaticController@index', 'as' => 'home']);

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified'], function () {
    // Frontend
    Route::get('/posts/add', ['uses' => 'HomeStaticController@showPostForm', 'as' => 'post.create']);
    Route::get('/posts/{slug}', ['uses' => 'HomeStaticController@showPost', 'as' => 'post.show']);
    Route::get('/profile/{username}', ['uses' => 'HomeStaticController@showProfile', 'as' => 'profile']);
    
    // Backend Handler
    Route::get('{path}', ['uses' => 'HomeStaticController@adminIndex', 'as' => 'admin'])->where('path', '([A-z\d\-\/_.]+)?')->middleware('admin');

});

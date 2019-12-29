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

Route::get('/contact', ['uses' => 'HomeStaticController@showContactForm', 'as' => 'contact']);

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified'], function () {
    // Frontend
    Route::group(['middleware' => 'verifiedFromAdmin'], function () {
        Route::get('/posts/add', ['uses' => 'HomeStaticController@showPostForm', 'as' => 'post.create']);
        Route::get('/posts/{slug}', ['uses' => 'HomeStaticController@showPost', 'as' => 'post.show']);
    });
    Route::get('/profile/{username}', ['uses' => 'HomeStaticController@showProfile', 'as' => 'profile']);
    Route::get('/settings', ['uses' => 'HomeStaticController@showSettings', 'as' => 'settings']);
    
    // Backend Handler
    Route::get('{path}', ['uses' => 'HomeStaticController@adminIndex', 'as' => 'admin'])->where('path', '([A-z\d\-\/_.]+)?')->middleware('admin');
});

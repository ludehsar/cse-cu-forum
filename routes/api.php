<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    // Categories
    Route::get('/categories/all', ['uses' => 'API\CategoryAPIController@getAllCategories']);
    Route::get('/categories/{id}', ['uses' => 'API\CategoryAPIController@getCategory']);
    Route::post('/categories/create/new', ['uses' => 'API\CategoryAPIController@addCategory']);
    Route::put('/categories/edit/{id}', ['uses' => 'API\CategoryAPIController@editCategory']);
    Route::delete('/categories/delete/{id}', ['uses' => 'API\CategoryAPIController@deleteCategory']);

    // Tags
    Route::get('/tags/all', ['uses' => 'API\TagAPIController@getAllTags']);
    Route::get('/tags/{id}', ['uses' => 'API\TagAPIController@getTag']);
    Route::post('/tags/create/new', ['uses' => 'API\TagAPIController@addTag']);
    Route::put('/tags/edit/{id}', ['uses' => 'API\TagAPIController@editTag']);
    Route::delete('/tags/delete/{id}', ['uses' => 'API\TagAPIController@deleteTag']);

    // Posts
    Route::get('/posts/all', ['uses' => 'API\PostAPIController@getAllPosts']);
    Route::get('/posts/{id}', ['uses' => 'API\PostAPIController@getPost']);
    Route::get('/posts/{id}/tags', ['uses' => 'API\PostAPIController@getPostTags']);
    Route::post('/posts/create/new', ['uses' => 'API\PostAPIController@addPost']);
    Route::put('/posts/edit/{id}', ['uses' => 'API\PostAPIController@editPost']);
    Route::delete('/posts/delete/{id}', ['uses' => 'API\PostAPIController@deletePost']);

    // Users
    Route::get('/users/{id}', ['uses' => 'API\UserAPIController@getUser']);
    Route::get('/user', ['uses' => 'API\UserAPIController@getCurrentUser']);
});

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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
});

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
    Route::get('/categories/all', ['uses' => 'API\CategoryAPIController@getAllCategories']);
    Route::get('/categories/{id}', ['uses' => 'API\CategoryAPIController@getCategory']);
    Route::post('/categories/create/new', ['uses' => 'API\CategoryAPIController@addCategory']);
});

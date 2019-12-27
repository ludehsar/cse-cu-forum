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
    
    Route::group(['middleware' => 'admin'], function () {
        // Categories
        Route::post('/categories/create/new', ['uses' => 'API\CategoryAPIController@addCategory']);
        Route::put('/categories/edit/{id}', ['uses' => 'API\CategoryAPIController@editCategory']);
        Route::delete('/categories/delete/{id}', ['uses' => 'API\CategoryAPIController@deleteCategory']);

        // Tags
        Route::post('/tags/create/new', ['uses' => 'API\TagAPIController@addTag']);
        Route::put('/tags/edit/{id}', ['uses' => 'API\TagAPIController@editTag']);
        Route::delete('/tags/delete/{id}', ['uses' => 'API\TagAPIController@deleteTag']);

        // Users
        Route::put('/users/verify/{id}', ['uses' => 'API\UserAPIController@verifyUser']);
        Route::put('/users/block/{id}', ['uses' => 'API\UserAPIController@blockUser']);
        Route::put('/users/unblock/{id}', ['uses' => 'API\UserAPIController@unblockUser']);
        Route::put('/users/{id}/sft', ['uses' => 'API\UserAPIController@updateStudentFromTeacher']);
        Route::put('/users/{id}/tfs', ['uses' => 'API\UserAPIController@updateTeacherFromStudent']);
    });
    
    // Posts
    Route::post('/posts/create/new', ['uses' => 'API\PostAPIController@addPost']);
    Route::put('/posts/edit/{id}', ['uses' => 'API\PostAPIController@editPost']);
    Route::delete('/posts/delete/{id}', ['uses' => 'API\PostAPIController@deletePost']);
    
    // Users
    Route::get('/user', ['uses' => 'API\UserAPIController@getCurrentUser']);
    Route::post('/user/upload', ['uses' => 'API\UserAPIController@uploadProfilePicture']);
    Route::post('/user/bio', ['uses' => 'API\UserAPIController@updateBio']);
    Route::post('/user/change_password', ['uses' => 'API\UserAPIController@updatePassword']);
    Route::post('/user/change_profile', ['uses' => 'API\UserAPIController@updateProfile']);
    Route::post('/user/change_university_profile', ['uses' => 'API\UserAPIController@updateUniversityProfile']);
});

// Categories
Route::get('/categories/all', ['uses' => 'API\CategoryAPIController@getAllCategories']);
Route::get('/categories/{id}', ['uses' => 'API\CategoryAPIController@getCategory']);

// Tags
Route::get('/tags/all', ['uses' => 'API\TagAPIController@getAllTags']);
Route::get('/tags/{id}', ['uses' => 'API\TagAPIController@getTag']);

// Posts
Route::get('/posts/all', ['uses' => 'API\PostAPIController@getAllPosts']);
Route::get('/posts/frontend', ['uses' => 'API\PostAPIController@getFrontendPosts']);
Route::get('/posts/{id}', ['uses' => 'API\PostAPIController@getPost']);
Route::get('/posts/{id}/tags', ['uses' => 'API\PostAPIController@getPostTags']);

// Users
Route::get('/users/all', ['uses' => 'API\UserAPIController@getAllUsers']);
Route::get('/users/{id}', ['uses' => 'API\UserAPIController@getUser']);
Route::get('/users/{id}/complete', ['uses' => 'API\UserAPIController@getUserCompleteProfile']);
Route::get('/users/{id}/posts', ['uses' => 'API\UserAPIController@getPosts']);

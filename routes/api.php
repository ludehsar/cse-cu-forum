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

Route::get('/posts/frontend', ['uses' => 'API\PostAPIController@getFrontendPosts']);

Route::group(['middleware' => 'auth:api'], function () {
    
    Route::get('/categories/all', ['uses' => 'API\CategoryAPIController@getAllCategories']);
    Route::post('/categories/create/new', ['uses' => 'API\CategoryAPIController@addCategory']);
    Route::get('/tags/all', ['uses' => 'API\TagAPIController@getAllTags']);
    Route::post('/tags/create/new', ['uses' => 'API\TagAPIController@addTag']);
    
    Route::group(['middleware' => 'admin'], function () {
        // Categories
        Route::put('/categories/edit/{id}', ['uses' => 'API\CategoryAPIController@editCategory']);
        Route::delete('/categories/delete/{id}', ['uses' => 'API\CategoryAPIController@deleteCategory']);
        
        // Tags
        Route::put('/tags/edit/{id}', ['uses' => 'API\TagAPIController@editTag']);
        Route::delete('/tags/delete/{id}', ['uses' => 'API\TagAPIController@deleteTag']);
        
        // Users
        Route::put('/users/verify/{id}', ['uses' => 'API\UserAPIController@verifyUser']);
        Route::put('/users/block/{id}', ['uses' => 'API\UserAPIController@blockUser']);
        Route::put('/users/unblock/{id}', ['uses' => 'API\UserAPIController@unblockUser']);
        Route::put('/users/{id}/sft', ['uses' => 'API\UserAPIController@updateStudentFromTeacher']);
        Route::put('/users/{id}/tfs', ['uses' => 'API\UserAPIController@updateTeacherFromStudent']);

        // Reports
        Route::get('/reports/all', ['uses' => 'API\ReportAPIController@getAllReports']);
        Route::delete('/reports/delete/{id}', ['uses' => 'API\ReportAPIController@deleteReport']);

        // Dashboard
        Route::get('/dashboard/get-all', ['uses' => 'API\DashboardAPIController@getAllTotals']);
        Route::get('/dashboard/user-chart-dataset', ['uses' => 'API\DashboardAPIController@getUserDataset']);
        Route::get('/dashboard/post-chart-dataset', ['uses' => 'API\DashboardAPIController@getPostDataset']);
    });
    
    // Posts
    Route::get('/posts/all', ['uses' => 'API\PostAPIController@getAllPosts']);
    Route::get('/posts/{id}', ['uses' => 'API\PostAPIController@getPost']);
    Route::get('/posts/{id}/tags', ['uses' => 'API\PostAPIController@getPostTags']);
    Route::post('/posts/create/new', ['uses' => 'API\PostAPIController@addPost']);
    Route::put('/posts/edit/{id}', ['uses' => 'API\PostAPIController@editPost']);
    Route::delete('/posts/delete/{id}', ['uses' => 'API\PostAPIController@deletePost']);

    // Comments
    Route::get('/comments/all', ['uses' => 'API\CommentAPIController@getAllComments']);
    Route::get('/posts/{id}/comments', ['uses' => 'API\CommentAPIController@getCommentsOfPost']);
    Route::get('/comments/{id}/replies', ['uses' => 'API\CommentAPIController@getRepliesOfComment']);
    Route::get('/comments/{id}', ['uses' => 'API\CommentAPIController@getComment']);
    Route::post('/comments/add', ['uses' => 'API\CommentAPIController@addComment']);
    Route::put('/comments/{id}/edit', ['uses' => 'API\CommentAPIController@editComment']);
    Route::delete('/comments/{id}/delete', ['uses' => 'API\CommentAPIController@deleteComment']);
    
    // Users
    Route::get('/users/all', ['uses' => 'API\UserAPIController@getAllUsers']);
    Route::get('/users/{id}', ['uses' => 'API\UserAPIController@getUser']);
    Route::get('/users/{id}/complete', ['uses' => 'API\UserAPIController@getUserCompleteProfile']);
    Route::get('/users/{id}/posts', ['uses' => 'API\UserAPIController@getPosts']);
    Route::get('/user', ['uses' => 'API\UserAPIController@getCurrentUser']);
    Route::post('/user/upload', ['uses' => 'API\UserAPIController@uploadProfilePicture']);
    Route::post('/user/bio', ['uses' => 'API\UserAPIController@updateBio']);
    Route::post('/user/change_password', ['uses' => 'API\UserAPIController@updatePassword']);
    Route::post('/user/change_profile', ['uses' => 'API\UserAPIController@updateProfile']);
    Route::post('/user/change_university_profile', ['uses' => 'API\UserAPIController@updateUniversityProfile']);

    // Reports
    Route::post('/reports/add', ['uses' => 'API\ReportAPIController@addReport']);

    // Reactions
    Route::get('/posts/{id}/user-reaction', ['uses' => 'API\ReactionAPIController@getUserPostReaction']);
    Route::get('/comments/{id}/user-reaction', ['uses' => 'API\ReactionAPIController@getUserCommentReaction']);
    Route::post('/react', ['uses' => 'API\ReactionAPIController@addReaction']);

    // Contributions
    Route::get('/posts/{id}/user-contribution', ['uses' => 'API\ContributionAPIController@getUserPostContribution']);
    Route::get('/comments/{id}/user-contribution', ['uses' => 'API\ContributionAPIController@getUserCommentContribution']);
    Route::get('/posts/{id}/contributions', ['uses' => 'API\ContributionAPIController@getPostContributionInfo']);
    Route::get('/comments/{id}/contributions', ['uses' => 'API\ContributionAPIController@getCommentContributionInfo']);
    Route::post('/contribute', ['uses' => 'API\ContributionAPIController@addContribution']);
});

Route::get('/categories/{id}', ['uses' => 'API\CategoryAPIController@getCategory']);
Route::get('/tags/{id}', ['uses' => 'API\TagAPIController@getTag']);

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

//create user
Route::post('/register', 'API\AuthController@register');
//auth user
Route::post('/login', 'API\AuthController@login');

Route::group(['middleware' => ['jwt.auth']], function() {
    //create post
    Route::post('/posts', 'API\PostController@create');
    //comment on post
    Route::post('/post/comment', 'API\CommentController@create');
    //like/dislike post or comment
    Route::post('/post/like', 'API\PostController@like');
    Route::post('/post/dislike', 'API\PostController@dislike');
    //return all
});

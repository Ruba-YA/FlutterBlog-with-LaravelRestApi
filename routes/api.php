<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register' , [AuthController::class,'register']);
Route::post('/login' , [AuthController::class,'login']);


Route::group(['middleware'=>['auth:sanctum']],function()
{
    //User
    Route::get('/user' , [AuthController::class,'showuser']);
    Route::put('/user' , [AuthController::class,'update']);
    Route::post('/logout' , [AuthController::class,'logout']);

    //Post

    Route::get('/posts' , [PostController::class, 'index']) ; // all posts
    Route::post('/posts' , [PostController::class, 'store']) ; // create posts
    Route::get('/posts/{id}' , [PostController::class, 'show']) ; //show post by id
    Route::put('/posts/{id}' , [PostController::class, 'update']) ; // update Post
    Route::delete('/posts/{id}' , [PostController::class, 'destroy']) ; // delete post

    //Comments 

    Route::get('/posts/{id}/comments' , [CommentController::class, 'index']) ; // all comments of  a post
    Route::post('/posts/{id}/comments' , [CommentController::class, 'store']) ; // craete comment on a post
    Route::put('comments/{id}' , [CommentController::class, 'update']) ; // update a comment on a post 
    Route::delete('/comments/{id}' , [CommentController::class, 'destroy']) ; // delete a comment  on a post

    // Likes 

    Route::post('/posts/{id}/likes' , [LikeController::class, 'likeOrUnlike']) ; // like a post

    

});
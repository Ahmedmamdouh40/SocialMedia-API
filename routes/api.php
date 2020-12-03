<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'user'], function(){
    Route::post('/register',[AuthController::class , 'store']);
    Route::post('/login', [AuthController::class , 'login']);
    
});

Route::group(['prefix'=>'posts' , 'middleware'=>'auth:sanctum'],function(){
    Route::get('/',[PostController::class , 'index'] );
    Route::get('/me/{user_id}',[PostController::class , 'myPosts'] );
    Route::get('/{post}',[PostController::class , 'show'] );
    Route::post('/',[PostController::class , 'store'] );
    Route::put('/{post}',[PostController::class , 'update'] );
});

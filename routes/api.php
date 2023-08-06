<?php

use App\Http\Controllers\API\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/get_all_users',[UserController::class,'get_all_users']);
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
// Route::post('user/delete/{id}','UserController@deleteUser');
Route::post('/user/delete/{id}', [UserController::class, 'deleteUser']);
Route::get('/search_user',[UserController::class,'search_user']);
Route::post('/user/verifyEmail/{id}', [UserController::class, 'verifyEmail']);


Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'], function() {
    Route::get('/', [PostsController::class,'index']);
    Route::post('add', [PostsController::class,'add']);
    Route::post('update/{id}', [PostsController::class,'update']);
    Route::get('edit/{id}', [PostsController::class,'edit']);
    Route::delete('delete/{id}', [PostsController::class,'delete']);


});

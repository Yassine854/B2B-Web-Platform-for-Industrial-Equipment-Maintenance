<?php

use App\Http\Controllers\API\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
// use App\Http\Controllers\TypeController;
use App\Http\Controllers\TypeindustrieController;
use App\Http\Controllers\TypeproductController;

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


//Auth
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

//USERS
Route::get('/get_all_users',[UserController::class,'get_all_users']);
Route::post('/users/create/admin', [UserController::class, 'createAdmin']);
Route::post('/users/create/client', [UserController::class, 'createClient']);
Route::put('/users/edit/{id}', [UserController::class, 'updateUser']);
Route::put('/users/updateClientDetails/{id}', [UserController::class, 'updateClientDetails']);
Route::post('/user/verifyOldPassword/{id}', [UserController::class, 'verifyOldPassword']);
Route::put('/user/updatePassword/{id}', [UserController::class, 'updatePassword']);
Route::post('/user/delete/{id}', [UserController::class, 'deleteUser']);
Route::get('/search_user',[UserController::class,'search_user']);
Route::post('/user/verifyEmail/{id}', [UserController::class, 'verifyEmail']);

//Types_industrie
Route::get('/get_type_industries',[TypeindustrieController::class,'get_type_industries']);
Route::post('/types_industrie/create', [TypeindustrieController::class, 'createType']);
Route::put('/types_industrie/update/{id}', [TypeindustrieController::class, 'updateType']);
Route::post('/types_industrie/delete/{id}', [TypeindustrieController::class, 'deleteType']);
Route::get('/types_industrie/search_type',[TypeindustrieController::class,'searchType']);

//Types_products
Route::get('/get_type_products',[TypeproductController::class,'get_type_products']);
Route::post('/types_product/create', [TypeproductController::class, 'createType']);
Route::put('/types_product/update/{id}', [TypeproductController::class, 'updateType']);
Route::post('/types_product/delete/{id}', [TypeproductController::class, 'deleteType']);
Route::get('/types_product/search_type',[TypeproductController::class,'searchType']);







// Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'], function() {
//     Route::get('/', [PostsController::class,'index']);
//     Route::post('add', [PostsController::class,'add']);
//     Route::post('update/{id}', [PostsController::class,'update']);
//     Route::get('edit/{id}', [PostsController::class,'edit']);
//     Route::delete('delete/{id}', [PostsController::class,'delete']);


// });

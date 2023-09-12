<?php

use App\Http\Controllers\API\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
// use App\Http\Controllers\TypeController;
use App\Http\Controllers\TypeindustrieController;
use App\Http\Controllers\TypeproductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DiagnosticController;
use App\Http\Controllers\InterventionController;
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
Route::post('check-email', [UserController::class, 'check_email']);

Route::middleware('auth:sanctum')->group(function () {

// USERS
Route::get('/get_all_users',[UserController::class,'get_all_users']);
Route::post('/users/create/admin', [UserController::class, 'createAdmin']);
Route::post('/users/create/client', [UserController::class, 'createClient']);
Route::put('/users/edit/{id}', [UserController::class, 'updateUser']);
Route::put('/users/updateClientDetails/{id}', [UserController::class, 'updateClientDetails']);
Route::put('/users/requestVerification/{id}', [UserController::class, 'requestVerification']);
Route::post('/user/verifyOldPassword/{id}', [UserController::class, 'verifyOldPassword']);
Route::put('/user/updatePassword/{id}', [UserController::class, 'updatePassword']);
Route::post('/user/delete/{id}', [UserController::class, 'deleteUser']);
Route::get('/search_user',[UserController::class,'search_user']);
Route::post('/user/verifyEmail/{id}', [UserController::class, 'verifyEmail']);
Route::get('/get-client-count', [UserController::class, 'getClientCount']);



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

//Products
Route::get('/get_products',[ProductController::class,'get_products']);
Route::post('/products/create', [ProductController::class, 'createProduct']);
Route::post('/products/update/{id}', [ProductController::class, 'updateProduct']);
Route::get('/products/show/{id}', [ProductController::class, 'showProduct']);
Route::post('/products/delete/{id}', [ProductController::class, 'deleteProduct']);
Route::get('/products/search_product',[ProductController::class,'searchProduct']);



//Parc Clients
Route::get('/get_all_assignments',[AssignmentController::class,'get_all_assignments']);
Route::get('/get_client_assignments/{id}', [AssignmentController::class, 'get_client_assignments']);
Route::get('/get_all_clients',[AssignmentController::class,'get_all_clients']);
Route::get('/get_all_products',[AssignmentController::class,'get_all_products']);
Route::post('/assignments/create', [AssignmentController::class, 'createAssignment']);
Route::put('/assignments/update/{id}', [AssignmentController::class, 'updateAssignment']);
Route::get('/assignments/show/{id}', [AssignmentController::class, 'showAssignment']);
Route::post('/assignments/delete/{id}', [AssignmentController::class, 'deleteAssignment']);
Route::get('/assignments/search_assignment',[AssignmentController::class,'search_assignment']);
Route::get('/assignments/search_society',[AssignmentController::class,'search_society']);
Route::get('/assignments/search_product', [AssignmentController::class, 'search_product']);
Route::put('/assignments/updateHuile/{id}', [AssignmentController::class, 'updateHuile']);
Route::put('/assignments/updateFiltre/{id}', [AssignmentController::class, 'updateFiltre']);
Route::put('/assignments/updateDeshuil/{id}', [AssignmentController::class, 'updateDeshuil']);
Route::put('/assignments/updateEntretien/{id}', [AssignmentController::class, 'updateEntretien']);



//Parc
Route::get('/get_assignments/{id}',[AssignmentController::class,'get_assignments']);

//Diagnostic
Route::get('/get_all_diagnostics', [DiagnosticController::class, 'get_all_diagnostics']);
Route::post('/diagnostics/create', [DiagnosticController::class, 'createDiagnostic']);
Route::put('/diagnostics/update/{id}', [DiagnosticController::class, 'updateDiagnostic']);
Route::post('/diagnostics/delete/{id}', [DiagnosticController::class, 'deleteDiagnostic']);



//Interventions
Route::get('/get_all_interventions',[InterventionController::class,'get_all_interventions']);
Route::get('/interventions/get_all_assignments',[InterventionController::class,'get_all_assignments']);
Route::post('/interventions/create', [InterventionController::class, 'createIntervention']);
Route::put('/interventions/update/{id}', [InterventionController::class, 'updateIntervention']);
Route::post('/interventions/delete/{id}', [InterventionController::class, 'deleteIntervention']);
Route::get('/interventions/show/{id}', [InterventionController::class, 'showIntervention']);
Route::get('/get-intervention-count', [InterventionController::class, 'getInterventionCount']);

//Notification
Route::get('/get_all_notifications',[NotificationController::class,'get_all_notifications']);
Route::post('/notifications/markAsRead/{id}',[NotificationController::class,'markAsRead']);
Route::get('/get-notification-count', [NotificationController::class, 'getNotificationCount']);

});
// Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'], function() {
//     Route::get('/', [PostsController::class,'index']);
//     Route::post('add', [PostsController::class,'add']);
//     Route::post('update/{id}', [PostsController::class,'update']);
//     Route::get('edit/{id}', [PostsController::class,'edit']);
//     Route::delete('delete/{id}', [PostsController::class,'delete']);


// });

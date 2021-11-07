<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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




/*Route::get('/show/{id}', [ApiController::class, 'show']);
Route::get('/product_show/{id}', [ApiController::class, 'show']); */
//Route::resource('products', ApiController::class);



Route::any('/user/form/{application_no}', [UserFormController::class, 'userform']);


Route::get('/home', [ApiController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('products/search/{name}', [ApiController::class, 'search']);
Route::get('/product/{id}', [ApiController::class, 'show']);



Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/product_create', [ApiController::class, 'store']);
    Route::put('/product_update/{id}', [ApiController::class, 'update']);
    Route::delete('/product_delete/{id}', [ApiController::class, 'destroy']);
    Route::get('/logout', [UserController::class, 'logout']);
});

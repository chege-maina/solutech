<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->post('register', 'register');
    Route::middleware('auth:sanctum')->get('getUsers', 'listUsers');
    Route::post('forgotpsw', 'forgotPassword');
    Route::middleware('auth:sanctum')->post('statusUsr', 'changeStatus');
    Route::middleware('auth:sanctum')->post('delete/{id}', 'deleteUser');
    Route::middleware('auth:sanctum')->post('edit', 'editUser');
    Route::middleware('auth:sanctum')->post('getuser/{id}', 'getEmail');
    Route::middleware('auth:sanctum')->post('changepsw/{id}', 'changePassword');
    Route::middleware('auth:sanctum')->get('CurrentDate', 'CurrentDate');
});

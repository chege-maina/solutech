<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TaskController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->post('register', 'register');
    Route::middleware('auth:sanctum')->get('getUsers', 'listUsers');
    Route::post('forgotpsw', 'forgotPassword');
    Route::middleware('auth:sanctum')->post('statusUsr', 'changeStatus');
    Route::middleware('auth:sanctum')->post('delete/{id}', 'deleteUser');
    Route::middleware('auth:sanctum')->post('edit', 'editUser');
    Route::middleware('auth:sanctum')->get('getuser/{id}', 'getEmail');
    Route::middleware('auth:sanctum')->post('changepsw/{id}', 'changePassword');
    Route::middleware('auth:sanctum')->get('CurrentDate', 'CurrentDate');
});
Route::controller(RoleController::class)->group(function () {
    Route::middleware('auth:sanctum')->get('getRoles', 'listRoles');
});
Route::controller(TaskController::class)->group(function () {
    Route::middleware('auth:sanctum')->get('getTasks', 'listTasks');
    Route::middleware('auth:sanctum')->post('addTask', 'addTask');
    Route::middleware('auth:sanctum')->post('editTask', 'editTask');
    Route::middleware('auth:sanctum')->post('editRemarks', 'editRemarks');
    Route::middleware('auth:sanctum')->post('deleteTask/{id}', 'deleteTask');
    Route::middleware('auth:sanctum')->post('completeTask/{id}', 'completeTask');
    Route::middleware('auth:sanctum')->post('assignTask', 'assignTask');
    Route::middleware('auth:sanctum')->get('userTasks/{id}', 'userTasks');
});
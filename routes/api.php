<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::prefix('v1')->group(function ()
{
    Route::post('/user',[UserController::class,"Register"]);
    Route::get('/validate',[UserController::class,"ValidateToken"])->middleware('auth:api');
    Route::get('/logout',[UserController::class,"Logout"])->middleware('auth:api');
});

Route::prefix('v2')->group(function ()
{
    Route::post('/registrar',[UserController::class,"Register"]);
    Route::get('/validar',[UserController::class,"ValidateToken"])->middleware('auth:api');
    Route::post('/usuario/validar',[UserController::class,"Login"]);
    Route::get('/usuario/roles/{id}',[UserController::class,"GetUsuarioRoles"]);
    Route::get('/logout',[UserController::class,"Logout"])->middleware('auth:api');
});

Route::prefix('v3')->group(function ()
{
    Route::post('/registrar',[UserController::class,"Register"]);
    Route::get('/validar',[UserController::class,"ValidateToken"])->middleware('auth:api');
    Route::post('/usuario/validar',[UserController::class,"Login"]);
    Route::get('/usuario/roles/{id}',[UserController::class,"GetUsuarioRoles"]);
    Route::get('/logout',[UserController::class,"Logout"])->middleware('auth:api');
});
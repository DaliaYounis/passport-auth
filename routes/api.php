<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',           [RegisterController::class, 'register'])->name('api.register');
Route::post('/login',              [LoginController::class, 'login'])->name('api.login');
Route::post('/forgot-password',    [ForgotPasswordController::class, 'forgotPassword']);


Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/product',    [ProductController::class, 'index']);
    Route::get('/logout',     [LoginController::class, 'logout'])->name('api.logout');

});


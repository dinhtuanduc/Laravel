<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',[AuthController::class,'home'])->middleware('check.logout');;
Route::get('/login',[AuthController::class,'login'])->middleware('check.login');
Route::get('/logout',[AuthController::class,'logout']);
Route::post('/login',[AuthController::class,'postLogin']);
Route::get('/register',[AuthController::class,'register']);
Route::post('/register',[AuthController::class,'postRegister']);
Route::post('/check-email',[AuthController::class,'checkEmail']);
Route::get('/forgot-password',[AuthController::class,'forgotPassword']);
Route::post('/forgot-password',[AuthController::class,'postForgotPassword']);

Route::get('/reset-password',[AuthController::class,'resetPassword'])->name('reset.password');
Route::post('/reset-password',[AuthController::class,'postResetPassword']);

Route::get('/email-verified',[AuthController::class,'emailVerified'])->name('email.verified');


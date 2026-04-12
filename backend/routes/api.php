<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StaffController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login' , [AuthController::class , 'login']);
Route::post('/register' , [AuthController::class , 'register']);
Route::post('/logout', [AuthController::class , 'logout']);
Route::get('/me' , [AuthController::class , 'me']);

/* Admin Routes */
Route::get('/admin' , [AdminController::class , 'index']);
Route::get('/admin/staff/all' , [StaffController::class , 'index']);
Route::post('/admin/staff/add' , [AdminController::class , 'storeRH']);
Route::get('/admin/staff/{id}' , [AdminController::class , 'showRH']);
Route::put('/admin/staff/{id}/edit' , [AdminController::class , 'updateRH']);
Route::delete('/admin/staff/{id}/delete' , [AdminController::class , 'destroyRH']);


Route::get('/staff' , [StaffController::class , 'index']);
Route::get('/staff/{id}' , [StaffController::class , 'show']);


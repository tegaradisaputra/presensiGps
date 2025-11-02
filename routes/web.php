<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;


Route::middleware(['guest:employee'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});


Route::middleware(['auth:employee'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);
    
    Route::get('/attendance/create', [AttendanceController::class, 'create']);
    Route::post('/attendance/store', [AttendanceController::class, 'store']);

    Route::get('/editProfil', [AttendanceController::class, 'editProfil']);
    Route::post('/employee/{nik}/updateProfil', [AttendanceController::class, 'updateProfil']);
});
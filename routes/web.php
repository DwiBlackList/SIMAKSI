<?php

use App\Http\Controllers\JoinedClassController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/mapel' , MapelController::class);
Route::resource('/kehadiran' , KehadiranController::class);
Route::resource('/siswa' , KehadiranController::class);
Route::resource('/settingkelas' , JoinedClassController::class);
Route::resource('/nilai' , NilaiController::class);
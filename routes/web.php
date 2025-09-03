<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('add-client', [ClientController::class, 'addForm']);
    Route::post('add-client', [ClientController::class, 'store']);
    Route::get('edit-client/{id}', [ClientController::class, 'editForm']);
    Route::put('/edit-client/{id}', [ClientController::class, 'update']);
    Route::delete('delete-client/{id}', [ClientController::class, 'destroy'])->name('client.delete');
    Route::get('/view-clients', [ClientController::class, 'index'])->name('clients.index');

    // for ajax based client list in grid.js
    Route::get('/api/clients', function () {
        return \App\Models\Client::all();
    });

    Route::get('add-user', [UserController::class, 'addForm']);
    Route::post('add-user', [UserController::class, 'store']);
    Route::post('check-username', [UserController::class, 'checkUsername']);
    Route::get('/view-users', [UserController::class, 'index']);
    Route::get('edit-user/{id}', [UserController::class, 'editForm']);
    Route::delete('delete-user/{id}', [UserController::class, 'destroy'])->name('user.delete');

    
    Route::post('/change-password', [PasswordController::class, 'change'])->name('password.change');
});

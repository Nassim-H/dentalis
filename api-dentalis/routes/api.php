<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

// Routes pour la gestion des comptes et l'authentification
Route::prefix('users')->group(function () {
    // Authentification
    Route::post('register', [UserController::class, 'register']); //Fait
    Route::post('login', [UserController::class, 'login']); //Fait
    Route::get('me', [UserController::class, 'me'])->middleware('auth:sanctum'); //Fait
    Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum'); //Fait
    
    // Gestion des comptes  
    Route::delete('deleteUser/', [UserController::class, 'delete'])->middleware(['auth:sanctum', 'admin']); //Fait
    Route::patch('updateUser/', [UserController::class, 'updateUser'])->middleware(['auth:sanctum', 'admin']); //Fait

    Route::get('verifyEmail/{id}/{hash}', [UserController::class, 'verifyEmail'])->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
});

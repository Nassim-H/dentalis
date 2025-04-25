<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\AppointmentController;

// =========================
// 📦 AUTH & USERS
// =========================
Route::prefix('auth')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('me', [UserController::class, 'me'])->middleware('auth:sanctum');
    Route::get('verify-email/{id}/{hash}', [UserController::class, 'verifyEmail'])
        ->middleware(['signed'])->name('verification.verify');
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::patch('{id}/set-doctor', [UserController::class, 'setDoctor']);
    Route::patch('{id}', [UserController::class, 'updateUser']);
    Route::delete('{id}', [UserController::class, 'delete']);
});

// =========================
// 🧑‍⚕️ DOCTORS
// =========================
Route::middleware(['auth:sanctum', 'doctor'])->prefix('doctor')->group(function () {
    Route::get('appointments', [AppointmentController::class, 'indexDoctor']); // RDV reçus
    Route::get('availabilities', [AvailabilityController::class, 'indexOwn']); // Ses dispos
    Route::post('availabilities', [AvailabilityController::class, 'store']);
    Route::delete('availabilities/{id}', [AvailabilityController::class, 'destroy']);
    Route::patch('/users/{id}/set-admin', [UserController::class, 'setAdmin']);
});


// =========================
// 👤 PATIENTS
// =========================
Route::middleware(['auth:sanctum', 'patient'])->prefix('patient')->group(function () {
    Route::get('appointments', [AppointmentController::class, 'indexPatient']); 
    Route::post('appointments', [AppointmentController::class, 'store']);
    Route::patch('appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy']);
});

// =========================
// 📅 PUBLIC ROUTES
// =========================
Route::get('/doctors/{id}/availabilities', [AvailabilityController::class, 'indexPublic']); // affichage public RDV
Route::get('/doctors', [UserController::class, 'listDoctors']);
Route::get('/doctors/{id}/appointments', [AppointmentController::class, 'publicIndex']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes d'authentification 
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

// Routes tickets
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'index']); // Liste
    Route::post('/tickets', [TicketController::class, 'store']); // Création
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']); // Détail
    Route::put('/tickets/{ticket}', [TicketController::class, 'update']); // Mise à jour
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']); // Suppression
});

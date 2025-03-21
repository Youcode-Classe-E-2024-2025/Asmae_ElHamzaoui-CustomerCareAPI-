<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\InteractionController;

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

// Routes interactions
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tickets/{ticket}/interactions', [InteractionController::class, 'index']); // Liste des interactions
    Route::post('/tickets/{ticket}/interactions', [InteractionController::class, 'store']); // Ajouter une interaction
    Route::get('/interactions/{interaction}', [InteractionController::class, 'show']); // Voir une interaction
    Route::put('/interactions/{interaction}', [InteractionController::class, 'update']); // Modifier une interaction
    Route::delete('/interactions/{interaction}', [InteractionController::class, 'destroy']); // Supprimer une interaction
});
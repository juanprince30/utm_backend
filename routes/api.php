<?php

use App\Http\Controllers\ChatbotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Chatbot de recherche de produits/services (proxy vers l'IA FastAPI)
Route::post('/chatbot', [ChatbotController::class, 'search'])->name('api.chatbot');

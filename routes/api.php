<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\CommandeController;

// Restaurant
Route::get('/restaurant/{twilio_number}', [RestaurantController::class, 'getByTwilio']);
Route::get('/restaurants', [RestaurantController::class, 'index']);

// Commandes
Route::post('/commandes', [CommandeController::class, 'store']);
Route::get('/commandes/{restaurant_id}', [CommandeController::class, 'index']);
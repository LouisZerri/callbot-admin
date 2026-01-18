<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\CommandeController;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('restaurants', RestaurantController::class);
    Route::post('restaurants/{restaurant}/categories', [RestaurantController::class, 'addCategorie'])->name('restaurants.addCategorie');
    Route::post('categories/{categorie}/articles', [RestaurantController::class, 'addArticle'])->name('categories.addArticle');
    Route::delete('articles/{article}', [RestaurantController::class, 'deleteArticle'])->name('articles.delete');
    Route::delete('categories/{categorie}', [RestaurantController::class, 'deleteCategorie'])->name('categories.delete');
    
    Route::get('commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
});
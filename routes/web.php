<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\CommandeController;

// Auth
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin (protégé)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('restaurants', RestaurantController::class);
    Route::post('restaurants/{restaurant}/categories', [RestaurantController::class, 'addCategorie'])->name('restaurants.addCategorie');
    Route::post('categories/{categorie}/articles', [RestaurantController::class, 'addArticle'])->name('categories.addArticle');
    Route::delete('articles/{article}', [RestaurantController::class, 'deleteArticle'])->name('articles.delete');
    Route::delete('categories/{categorie}', [RestaurantController::class, 'deleteCategorie'])->name('categories.delete');
    
    Route::get('commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');

});

// Restaurant (protégé)
Route::prefix('restaurant')->name('restaurant.')->middleware(['auth', 'restaurant'])->group(function () {
    Route::get('/', [App\Http\Controllers\Restaurant\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/commandes', [App\Http\Controllers\Restaurant\DashboardController::class, 'commandes'])->name('commandes');
    Route::get('/menu', [App\Http\Controllers\Restaurant\DashboardController::class, 'menu'])->name('menu');
    
    // Gestion menu
    Route::post('/categories', [App\Http\Controllers\Restaurant\DashboardController::class, 'addCategorie'])->name('categories.store');
    Route::delete('/categories/{categorie}', [App\Http\Controllers\Restaurant\DashboardController::class, 'deleteCategorie'])->name('categories.delete');
    Route::post('/categories/{categorie}/articles', [App\Http\Controllers\Restaurant\DashboardController::class, 'addArticle'])->name('articles.store');
    Route::put('/articles/{article}', [App\Http\Controllers\Restaurant\DashboardController::class, 'updateArticle'])->name('articles.update');
    Route::delete('/articles/{article}', [App\Http\Controllers\Restaurant\DashboardController::class, 'deleteArticle'])->name('articles.delete');
    
    // Supprimer compte
    Route::delete('/compte', [App\Http\Controllers\Restaurant\DashboardController::class, 'deleteCompte'])->name('compte.delete');
});
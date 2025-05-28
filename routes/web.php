<?php

use App\Http\Controllers\OfferController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserProfileController; // Assurez-vous d'importer le bon contrôleur
use Illuminate\Support\Facades\Route;

Route::get('/', [OfferController::class, 'index'])->name('home');

// Routes publiques d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Route publique accessible sans connexion
Route::get('/offers/archive', [OfferController::class, 'archive'])->name('offers.archive');

// Route pour le profil utilisateur
Route::get('/profile', [ UserProfileController::class, 'show'])->middleware('auth');
Route::get('/conseil', function () {
    return view('offers.conseil');})->name('conseil');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/publish-offer', [OfferController::class, 'create'])->name('offers.create');
    Route::post('/publish-offer', [OfferController::class, 'store'])->name('offers.store');
});

// Routes admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/utilisateurs', [AdminController::class, 'users'])->name('admin.users');
});

// Route de déconnexion
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

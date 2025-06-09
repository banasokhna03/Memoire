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
Route::get('/offers/{id}', [OfferController::class, 'show'])->name('offers.show');

// Route pour le profil utilisateur
Route::get('/profile', [ UserProfileController::class, 'show'])->middleware('auth');
Route::get('/conseil', function () {
    return view('offers.conseil');})->name('conseil');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/publish-offer', [OfferController::class, 'create'])->name('offers.create');
    Route::post('/publish-offer', [OfferController::class, 'store'])->name('offers.store');
    
    // Routes pour les candidatures
    Route::get('/offers/{id}/apply', [\App\Http\Controllers\ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/offers/{id}/apply', [\App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/success/{id}', [\App\Http\Controllers\ApplicationController::class, 'success'])->name('applications.success');
    Route::get('/my-applications', [\App\Http\Controllers\ApplicationController::class, 'index'])->name('applications.index');
});

// Routes admin
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/utilisateurs', [AdminController::class, 'users'])->name('admin.users');
    
    // Routes pour la gestion des offres par l'administrateur
    Route::get('/admin/offers/pending', [AdminController::class, 'pendingOffers'])->name('admin.offers.pending');
    Route::post('/admin/offers/{id}/validate', [AdminController::class, 'validateOffer'])->name('admin.offers.validate');
    Route::post('/admin/offers/{id}/reject', [AdminController::class, 'rejectOffer'])->name('admin.offers.reject');
});

// Route de déconnexion
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

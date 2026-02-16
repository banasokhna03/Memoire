<?php

use App\Http\Controllers\OfferController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserProfileController; 
use App\Http\Controllers\AdminApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', [OfferController::class, 'index'])->name('home');
Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');

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
    
    // Routes pour la gestion des secteurs d'activité
    Route::resource('admin/activity-sectors', \App\Http\Controllers\ActivitySectorController::class, [
        'names' => [
            'index' => 'admin.activity-sectors.index',
            'create' => 'admin.activity-sectors.create',
            'store' => 'admin.activity-sectors.store',
            'show' => 'admin.activity-sectors.show',
            'edit' => 'admin.activity-sectors.edit',
            'update' => 'admin.activity-sectors.update',
            'destroy' => 'admin.activity-sectors.destroy'
        ]
    ]);
    
    // Nouvelle route pour la modification d'utilisateur
    Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
    // Route pour afficher le formulaire de modification d'utilisateur
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    // Routes pour la gestion des offres par l'administrateur
    Route::get('/admin/offers/pending', [AdminController::class, 'pendingOffers'])->name('admin.offers.pending');
    Route::post('/admin/offers/{id}/validate', [AdminController::class, 'validateOffer'])->name('admin.offers.validate');
    Route::post('/admin/offers/{id}/reject', [AdminController::class, 'rejectOffer'])->name('admin.offers.reject');
    Route::get('/admin/offers/{id}/edit', [AdminController::class, 'editOffer'])->name('admin.offers.edit');
    Route::put('/admin/offers/{id}', [AdminController::class, 'updateOffer'])->name('admin.offers.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy']) ->name('admin.users.destroy');
        Route::delete('/admin/offers/{id}', [AdminController::class, 'deleteOffer'])->name('admin.offers.delete');

    // Dans le groupe de routes admin
Route::get('/admin/offers/active', [AdminController::class, 'activeOffers'])->name('admin.offers.active');
// Routes pour la gestion des candidatures par l'administrateur
    Route::get('/admin/applications', [AdminApplicationController::class, 'index'])->name('admin.applications.index');
    Route::get('/admin/applications/{id}', [AdminApplicationController::class, 'show'])->name('admin.applications.show');
    Route::get('/admin/applications/{id}/download-cv', [AdminApplicationController::class, 'downloadCV'])->name('admin.applications.download-cv');
    Route::patch('/admin/applications/{id}/status', [AdminApplicationController::class, 'updateStatus'])->name('admin.applications.update-status');
});
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
// Route de déconnexion
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/chat', function () {
    return view('chat');
})->name('chat.index');

Route::post('/chat/send', [ChatController::class, 'ask']);
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', [PublicController::class, 'welcome'])->name('main');

// Pages publiques
Route::get('/commerces',                           [PublicController::class, 'commerces_index'])->name('commerces.index');
Route::get('/commerces/{commerce}',                [PublicController::class, 'commerces_show'])->name('commerces.show');
Route::get('/services',                            [PublicController::class, 'services_index'])->name('services.index');
Route::get('/chatbot',                             [PublicController::class, 'chatbot'])->name('chatbot');

// Auth forms
Route::get('/login',          [AuthController::class, 'show_login'])->name('login.form');
Route::get('/register',       [AuthController::class, 'show_register'])->name('register.form');
Route::get('/otpverification',[AuthController::class, 'show_otp'])->name('otp.form');
Route::get('/forgotpassword', [AuthController::class, 'show_forgotpassword'])->name('forgotpassword.form');
Route::get('/resetpassword',  [AuthController::class, 'show_resetpassword'])->name('resetpassword.form');

// Auth actions
Route::post('/login',          [AuthController::class, 'login_admin'])->name('login');
Route::post('/register',       [AuthController::class, 'register'])->name('register');
Route::post('/forgotpassword', [AuthController::class, 'forgot_password'])->name('forgot.password');
Route::post('/otpverification',[AuthController::class, 'verify_otp'])->name('verify.otp');
Route::post('/resetpassword',  [AuthController::class, 'reset_password'])->name('reset.password');

Route::middleware('auth')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile',  [AuthController::class, 'show_profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'update_profile'])->name('profile.update');

    // Commentaires (authentifie)
    Route::post('/commerces/{commerce}/commentaires', [PublicController::class, 'commerce_comment'])->name('commerces.comment');

    // Espace Artisan (canCommerce requis)
    Route::middleware('cancommerce')->prefix('artisan')->group(function () {
        Route::get('/commentaires', [ArtisanController::class, 'commentaires_index'])->name('artisan.commentaires');
        Route::get('/dashboard',                        [ArtisanController::class, 'dashboard'])->name('artisan.dashboard');
        Route::get('/commerces',                        [ArtisanController::class, 'commerces_index'])->name('artisan.commerces');
        Route::get('/commerces/create',                 [ArtisanController::class, 'commerces_create'])->name('artisan.commerces.create');
        Route::post('/commerces/verify-description',     [ArtisanController::class, 'commerces_verify_description'])->name('artisan.commerces.verify');
        Route::post('/commerces',                       [ArtisanController::class, 'commerces_store'])->name('artisan.commerces.store');
        Route::get('/commerces/{commerce}/edit',        [ArtisanController::class, 'commerces_edit'])->name('artisan.commerces.edit');
        Route::put('/commerces/{commerce}',             [ArtisanController::class, 'commerces_update'])->name('artisan.commerces.update');
        Route::patch('/commerces/{commerce}/status',    [ArtisanController::class, 'commerces_status'])->name('artisan.commerces.status');
        Route::delete('/commerces/{commerce}',          [ArtisanController::class, 'commerces_destroy'])->name('artisan.commerces.destroy');
        Route::get('/services',                         [ArtisanController::class, 'services_index'])->name('artisan.services');
        Route::get('/services/create',                  [ArtisanController::class, 'services_create'])->name('artisan.services.create');
        Route::post('/services',                        [ArtisanController::class, 'services_store'])->name('artisan.services.store');
        Route::get('/services/{service}/edit',          [ArtisanController::class, 'services_edit'])->name('artisan.services.edit');
        Route::put('/services/{service}',               [ArtisanController::class, 'services_update'])->name('artisan.services.update');
        Route::patch('/services/{service}/status',      [ArtisanController::class, 'services_status'])->name('artisan.services.status');
        Route::delete('/services/{service}',            [ArtisanController::class, 'services_destroy'])->name('artisan.services.destroy');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users',                        [AdminController::class, 'users_index'])->name('admin.users');
    Route::post('/users',                       [AdminController::class, 'users_store'])->name('admin.users.store');
    Route::get('/users/{user}',                 [AdminController::class, 'users_show'])->name('admin.users.show');
    Route::put('/users/{user}',                 [AdminController::class, 'users_update'])->name('admin.users.update');
    Route::delete('/users/{user}',              [AdminController::class, 'users_destroy'])->name('admin.users.destroy');
    Route::patch('/users/{user}/actif',         [AdminController::class, 'users_toggle_actif'])->name('admin.users.actif');
    Route::patch('/users/{user}/commerce',      [AdminController::class, 'users_toggle_commerce'])->name('admin.users.commerce');
    Route::patch('/users/{user}/certified',     [AdminController::class, 'users_toggle_certified'])->name('admin.users.certified');
    Route::get('/commerces',                        [AdminController::class, 'commerces_index'])->name('admin.commerces');
    Route::get('/commerces/{commerce}',             [AdminController::class, 'commerces_show'])->name('admin.commerces.show');
    Route::patch('/commerces/{commerce}/publication',[AdminController::class, 'commerces_toggle_publication'])->name('admin.commerces.publication');
    Route::delete('/commerces/{commerce}',          [AdminController::class, 'commerces_destroy'])->name('admin.commerces.destroy');
    Route::get('/services',                         [AdminController::class, 'services_index'])->name('admin.services');
    Route::get('/services/{service}',               [AdminController::class, 'services_show'])->name('admin.services.show');
    Route::patch('/services/{service}/disponibilite',[AdminController::class, 'services_toggle_disponibilite'])->name('admin.services.disponibilite');
    Route::delete('/services/{service}',            [AdminController::class, 'services_destroy'])->name('admin.services.destroy');

    // Commentaires
    Route::get('/commentaires',                         [AdminController::class, 'commentaires_index'])->name('admin.commentaires');
    Route::delete('/commentaires/{commentaire}',        [AdminController::class, 'commentaires_destroy'])->name('admin.commentaires.destroy');
});

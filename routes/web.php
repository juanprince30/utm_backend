<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("welcome");
})->name('main');

Route::get('/chatbot', function () {
    return view('main.chat_bot');
})->name('chatbot');


// Affichage des formulaires
Route::get('/login',          [AuthController::class, 'show_login'])->name('login.form');
Route::get('/register',       [AuthController::class, 'show_register'])->name('register.form');
Route::get('/otpverification',[AuthController::class, 'show_otp'])->name('otp.form');
Route::get('/forgotpassword', [AuthController::class, 'show_forgotpassword'])->name('forgotpassword.form');
Route::get('/resetpassword',  [AuthController::class, 'show_resetpassword'])->name('resetpassword.form');

// Actions d'authentification
Route::post('/login',          [AuthController::class, 'login_admin'])->name('login');
Route::post('/register',       [AuthController::class, 'register'])->name('register');
Route::post('/forgotpassword', [AuthController::class, 'forgot_password'])->name('forgot.password');
Route::post('/otpverification',[AuthController::class, 'verify_otp'])->name('verify.otp');
Route::post('/resetpassword',  [AuthController::class, 'reset_password'])->name('reset.password');

Route::middleware('auth')->group(function(){
    Route::post('/logout',          [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile',          [AuthController::class, 'show_profile'])->name('profile');
    Route::post('/profile',         [AuthController::class, 'update_profile'])->name('profile.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Utilisateurs
    Route::get('/users',                        [AdminController::class, 'users_index'])->name('admin.users');
    Route::post('/users',                       [AdminController::class, 'users_store'])->name('admin.users.store');
    Route::get('/users/{user}',                 [AdminController::class, 'users_show'])->name('admin.users.show');
    Route::put('/users/{user}',                 [AdminController::class, 'users_update'])->name('admin.users.update');
    Route::delete('/users/{user}',              [AdminController::class, 'users_destroy'])->name('admin.users.destroy');
    Route::patch('/users/{user}/actif',         [AdminController::class, 'users_toggle_actif'])->name('admin.users.actif');
    Route::patch('/users/{user}/commerce',      [AdminController::class, 'users_toggle_commerce'])->name('admin.users.commerce');
    Route::patch('/users/{user}/certified',     [AdminController::class, 'users_toggle_certified'])->name('admin.users.certified');

    // Commerces
    Route::get('/commerces',                        [AdminController::class, 'commerces_index'])->name('admin.commerces');
    Route::get('/commerces/{commerce}',             [AdminController::class, 'commerces_show'])->name('admin.commerces.show');
    Route::patch('/commerces/{commerce}/publication',[AdminController::class, 'commerces_toggle_publication'])->name('admin.commerces.publication');
    Route::delete('/commerces/{commerce}',          [AdminController::class, 'commerces_destroy'])->name('admin.commerces.destroy');

    // Services
    Route::get('/services',                         [AdminController::class, 'services_index'])->name('admin.services');
    Route::get('/services/{service}',               [AdminController::class, 'services_show'])->name('admin.services.show');
    Route::patch('/services/{service}/disponibilite',[AdminController::class, 'services_toggle_disponibilite'])->name('admin.services.disponibilite');
    Route::delete('/services/{service}',            [AdminController::class, 'services_destroy'])->name('admin.services.destroy');
});

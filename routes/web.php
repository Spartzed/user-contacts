<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::get('/reset-password/{token}', [AuthController::class, 'showRestPasswordForm'])->name('password.reset');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::delete('/account/delete', [AuthController::class, 'destroy'])->name('account.delete')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/api/buscar-endereco', [ContactController::class, 'buscarEndereco']);
    Route::get('/api/buscar-endereco-por-cep', [ContactController::class, 'buscarEnderecoPorCep']);
});
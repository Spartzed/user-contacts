<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::get('/reset-password/{token}', [AuthController::class, 'showRestPasswordForm'])->name('reset-password');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::delete('/account/delete', [AuthController::class, 'destroy'])->name('account.delete')->middleware('auth');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index')->middleware('auth');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create')->middleware('auth');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store')->middleware('auth');
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contacts.edit')->middleware('auth');
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update')->middleware('auth');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy')->middleware('auth');
Route::get('/api/buscar-endereco', [ContactController::class, 'buscarEndereco'])->middleware('auth');
Route::get('/api/buscar-endereco-por-cep', [ContactController::class, 'buscarEnderecoPorCep'])->middleware('auth');
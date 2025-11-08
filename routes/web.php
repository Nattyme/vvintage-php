<?php
declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\PasswordSetNewController;


/* Authorization */
Route::get('/login', [LoginController::class, 'renderForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
Route::post('/registration', [RegistrationController::class, 'register']);

Route::get('/password/reset', [PasswordResetController::class, 'index'])->name('password-reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset']);
Route::get('/password/reset/{token}', [PasswordSetNewController::class, 'index'])->name('password-set-new');
Route::post('/password/reset/{token}', [PasswordSetNewController::class, 'setNew']);
/* Authorization */



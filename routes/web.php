<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/login');

Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'create')->name('login');

    Route::post('/login', 'store');

    Route::post('/logout', 'destroy')
        ->middleware('auth')
        ->name('logout');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::match(['get', 'post'], '/invite', [InvitationController::class, 'invite'])
        ->name('invite')
        ->middleware('role:super_admin,admin');

    Route::match(['get', 'post'], '/urls/generate', [ShortUrlController::class, 'generateURL'])
        ->name('urls.generate')
        ->middleware('role:admin,member');
});

Route::get('/accept/invite/{token}', [InvitationController::class, 'acceptInvite'])->name('accept.invite');
Route::post('/process/invite/{token}', [InvitationController::class, 'processInvite'])->name('process.invite');

Route::get('/{short_code}', [ShortUrlController::class, 'resolve'])->name('url.resolve');

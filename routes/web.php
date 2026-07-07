<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\MemoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// No personalized link on the bare homepage -> waiting page (missing reason).
Route::get('/', [InviteController::class, 'index'])->name('home');

// Personalized invite link: /invite/<encoded-guest-token>
Route::get('/invite/{token}', [InviteController::class, 'show'])
    ->where('token', '[^/]+')
    ->name('invite.show');

Route::get('/waiting', [InviteController::class, 'waiting'])->name('waiting');

// Facebook-style timeline of "our" memories.
Route::get('/memorize', [MemoryController::class, 'index'])->name('memorize');

// Elegant greenery-framed invitation profile card.
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');

// Admin dashboard — RSVP/comments overview + personalized invite-link generator.
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::post('/dashboard/login', [DashboardController::class, 'login'])->name('dashboard.login');
Route::post('/dashboard/logout', [DashboardController::class, 'logout'])->name('dashboard.logout');

Route::middleware('dashboard.auth')->group(function () {
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');
    Route::get('/dashboard/encode-inviter', [DashboardController::class, 'encodeInviter'])->name('dashboard.encode-inviter');
});


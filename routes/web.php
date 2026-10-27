<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardInviteController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\MediaConfigController;
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
Route::get('/thiep-cuoi', [InviteController::class, 'index'])->name('thiep-cuoi');

// Facebook-style timeline of "our" memories.
Route::get('/memorize', [MemoryController::class, 'index'])->name('memorize');

// Elegant greenery-framed invitation profile card.
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');

// Admin dashboard — RSVP/comments overview + personalized invite-link generator.
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::post('/dashboard/login', [DashboardController::class, 'login'])->name('dashboard.login');
Route::post('/dashboard/logout', [DashboardController::class, 'logout'])->name('dashboard.logout');

// Image/video link settings (overrides config/wedding.php via data/media.json).
Route::get('/dashboard/config', [MediaConfigController::class, 'index'])->name('dashboard.config');

Route::middleware('dashboard.auth')->group(function () {
    Route::post('/dashboard/config', [MediaConfigController::class, 'update'])->name('dashboard.config.update');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');
    Route::get('/dashboard/invites', [DashboardInviteController::class, 'index'])->name('dashboard.invites.index');
    Route::post('/dashboard/invites', [DashboardInviteController::class, 'store'])->name('dashboard.invites.store');
    Route::get('/dashboard/invites/export', [DashboardInviteController::class, 'export'])->name('dashboard.invites.export');
    Route::delete('/dashboard/invites/{token}', [DashboardInviteController::class, 'destroy'])->where('token', '[^/]+')->name('dashboard.invites.destroy');
    Route::patch('/dashboard/comments/{id}', [DashboardController::class, 'updateComment'])->name('dashboard.comments.update');
    Route::delete('/dashboard/comments/{id}', [DashboardController::class, 'destroyComment'])->name('dashboard.comments.destroy');
});


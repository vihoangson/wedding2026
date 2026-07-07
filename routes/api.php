<?php

use App\Http\Controllers\MemoryCommentController;
use App\Http\Controllers\RsvpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Port of the legacy /api/save-rsvp.php endpoint.
Route::post('/rsvp', [RsvpController::class, 'store'])->name('api.rsvp.store');

// Add a comment to a /memorize timeline post.
Route::post('/memory-comments', [MemoryCommentController::class, 'store'])->name('api.memory-comments.store');

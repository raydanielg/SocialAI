<?php

use Illuminate\Support\Facades\Route;
use Modules\Videoai\App\Http\Controllers\Api\VideoAiController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::middleware(['web'])->prefix('v1')->group(function () {
    Route::post('upload-image', [VideoAiController::class, 'uploadImage'])
        ->name('upload-image');
    Route::post('video-ai/generate', [VideoAiController::class, 'generateVideo'])
        ->name('ai-generate-video');
    Route::get('video-ai/fetch/{id}/{provider}', [VideoAiController::class, 'fetchGenerateVideo'])
        ->name('ai-fetch-generate-video');
});

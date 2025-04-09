<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DescriptionTemplateController;
use App\Http\Controllers\Api\AiToolsGenerateController;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\BrandLogoController;
use App\Http\Controllers\Api\PublishImageController;

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

Route::group(['middleware' => ['throttle:api']], function () {

    Route::get('/description-templates', [DescriptionTemplateController::class, 'index'])
        ->name('api-description-templates');

    Route::post('ai-generate-text',  [AiToolsGenerateController::class, 'text'])
        ->name('api-ai-generate-text');
    Route::post('api-ai-generate-image',  [AiToolsGenerateController::class, 'image'])
        ->name('api-ai-generate-image');
    Route::post('ai-generate-video', [AiToolsGenerateController::class, 'video'])
        ->name('api-ai-generate-video');
    Route::post('ai-fetch-generate-video', [AiToolsGenerateController::class, 'fetchVideo'])
        ->name('api-ai-fetch-generate-video');
    Route::post('ai-generate-voice', [AiToolsGenerateController::class, 'voice'])
        ->name('api-ai-generate-voice');
    Route::post('ai-fetch-generate-voice', [AiToolsGenerateController::class, 'fetchVoice'])
        ->name('api-ai-fetch-generate-voice');
    Route::post('ai-generate-audio', [AiToolsGenerateController::class, 'audio'])
        ->name('api-ai-generate-audio');

    Route::post('process-image', [PublishImageController::class, 'process_image'])
        ->name('api.publish.process_image');
    Route::get('/brand-logo', [BrandLogoController::class, 'index'])
        ->name('api-brand-logo');
    Route::get('/assets', [AssetController::class, 'index'])
        ->name('api-assets');
});

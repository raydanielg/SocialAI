<?php

use Illuminate\Support\Facades\Route;
use Modules\Videoai\App\Http\Controllers\PromptPresetController;
use Modules\Videoai\App\Http\Controllers\VideoAiController;

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

Route::resource('generate', VideoAiController::class)
    ->only(['create', 'index'])
    ->names('generate');
Route::resource('prompt-preset', PromptPresetController::class)
    ->only(['store', 'update', 'destroy'])
    ->names('prompt-preset');

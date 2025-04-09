<?php

use Illuminate\Support\Facades\Route;
use Modules\Videoai\App\Http\Controllers\Admin\AiVideoOptionController;
use Modules\Videoai\App\Http\Controllers\Admin\PromptPresetController;

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

Route::resource('config', AiVideoOptionController::class)
    ->names('config');
Route::resource('prompt-preset', PromptPresetController::class);

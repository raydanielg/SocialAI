<?php

use App\Http\Controllers\Web as WEB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;


Route::patch('set-locale/{locale}', [LocaleController::class, 'update'])->name('set-locale');

Route::group(['middleware' => ['website']], function () {


// common
Route::get('/', [WEB\WebPageController::class, 'home'])->name('home');
Route::get('/about-us', [WEB\WebPageController::class, 'about']);
Route::get('/pricing', [WEB\WebPageController::class, 'pricing']);
Route::get('/faq', [WEB\WebPageController::class, 'faq']);
Route::resource('/contact-us', WEB\ContactController::class)->only('index', 'store');

// pages
Route::get('/team', [WEB\WebPageController::class, 'team']);
Route::get('/integrations', [WEB\WebPageController::class, 'integrations']);
Route::resource('/services', WEB\ServiceController::class)->only(['index', 'show']);
Route::get('/service-categories/{slug}', [WEB\ServiceController::class, 'categoryShow'])->name('service-categories.show');
Route::resource('/projects', WEB\ProjectController::class)->only(['index', 'show']);
Route::post('/jobs/{job}/application', [WEB\JobController::class, 'application'])->name('jobs.application');
Route::resource('/jobs', WEB\JobController::class)->only(['index', 'show']);
Route::resource('/integrations', WEB\IntegrationController::class)->only(['index', 'show']);

// blogs
Route::resource('/blogs', WEB\BlogController::class)->only(['index', 'show']);
Route::get('blogs/category/{slug}', [WEB\BlogController::class, 'category'])->name('blogs.category');
Route::get('blogs/tag/{slug}', [WEB\BlogController::class, 'tag'])->name('blogs.tag');

// newsletter
Route::post('/newsletter', [WEB\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
});
// others
Route::post('/credit/pay', [WEB\CreditPayController::class, 'store'])->name('credit.pay');
Route::get('/credit/pay/{status}', [WEB\CreditPayController::class, 'status']);
Route::get('/ai-tools', [WEB\WebPageController::class, 'aiTools'])->name('ai-tools.index');


Route::group(['middleware' => ['website']], function () {
// custom page
Route::get('/{slug}', [WEB\WebPageController::class, 'page']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User as USER;
use App\Http\Controllers\Api\LinkedController;
use App\Http\Controllers\Api\TiktokController;
use App\Http\Controllers\Api\TwitterController;
use App\Http\Controllers\Api\FacebookController;
use App\Http\Controllers\Api\InstagramController;

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'user']], function () {
   // Profile
   Route::get('profile', [USER\UserPanelController::class, 'accountSetting'])->name('account-settings');
   Route::put('profile', [USER\UserPanelController::class, 'accountSettingUpdate'])->name('account-settings.update');
   Route::get('change-password', [USER\UserPanelController::class, 'changePassword'])->name('change-password');
   Route::put('change-password', [USER\UserPanelController::class, 'updatePassword'])->name('update-password');

   Route::get('dashboard', [USER\DashboardController::class, 'index'])->name('dashboard');

   Route::resource('supports', USER\SupportController::class);


   Route::get('notifications', [USER\UserPanelController::class, 'userNotifications'])->name('notifications');
   Route::post('notifications/{notification}', [USER\UserPanelController::class, 'userNotificationsRead'])->name('notifications.read');

   // content
   Route::get('analytics', [USER\AnalyticController::class, 'index'])->name('analytics.index');
   Route::resource('assets', USER\AssetController::class);
   Route::resource('brands', USER\BrandController::class)->names('brand');

   Route::post('generate-content', [USER\GenerateController::class, 'content'])->name('generate-content');
   Route::post('generate-image', [USER\GenerateController::class, 'image'])->name('generate-image');
   Route::get('generate-stock-image', [USER\GenerateController::class, 'stockImage'])->name('generate-stock-image');
   Route::post('generate-video', [USER\GenerateVideoController::class, 'video'])->name('generate-video');
   Route::post('fetch-generate-video', [USER\GenerateVideoController::class, 'fetchVideo'])->name('fetch-video');
   Route::get('stock-video', [USER\GenerateVideoController::class, 'stockVideo'])->name('stock-video');


   Route::get('publish/{brandPost}', [USER\BrandPostController::class, 'show'])->name('publish');
   Route::resource('brand-posts', USER\BrandPostController::class)->only(['index', 'store', 'update', 'destroy']);
   Route::delete('brand-posts-platforms/{brandPostPlatform}', [USER\BrandPostController::class, 'removeSchedule'])->name('brand-post-platforms.removeSchedule');
   Route::resource('platforms', USER\PlatformController::class);

   Route::resource('credits', USER\CreditController::class)->only('index');

   Route::get('credit-logs', [USER\CreditLogController::class, 'index'])->name('credit-logs.index');
   Route::get('credit-history', [USER\CreditLogController::class, 'history'])->name('credit-logs.history');
   Route::resource('ai-tools', USER\AiToolsController::class)->only(['index', 'show'])->names('ai-tools');
   Route::post('ai-tools/bookmark', [USER\AiToolsController::class, 'bookmark'])->name('ai-tools.bookmark');
   Route::resource('ai-generated-history', USER\GeneratedHistoryController::class)->names('ai-generated-history');
   // subscription
   Route::get('subscription', [USER\SubscriptionController::class, 'index'])->name('subscription.index');
   Route::get('subscription/payment/{id}', [USER\SubscriptionController::class, 'payment'])->name('subscription.payment');
   Route::post('subscription/subscribe', [USER\SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
   Route::get('subscription/plan/{status}', [USER\SubscriptionController::class, 'status']);

   // image editorUser
   Route::get('image-editor/{uuid}', [USER\ImageEditorController::class, 'edit'])
      ->name('image-editor.edit');
});
Route::get('user/brand/{uuid}/share', [USER\BrandController::class, 'share'])
   ->name('brand.share');


Route::middleware(['auth', 'saas'])->group(function () {

   // facebook api
   Route::get('/oauth/redirect/facebook', [FacebookController::class, 'redirect'])->name('connect.facebook');
   Route::get('/oauth/callback/facebook', [FacebookController::class, 'callback'])->name('callback.facebook');

   // twitter api
   Route::get('/oauth/redirect/twitter', [TwitterController::class, 'redirect'])->name('connect.twitter');
   Route::get('/oauth/callback/twitter', [TwitterController::class, 'callback'])->name('callback.twitter');

   // instagram api
   Route::get('/oauth/redirect/instagram', [InstagramController::class, 'redirect'])->name('connect.instagram');
   Route::get('/oauth/callback/instagram', [InstagramController::class, 'callback'])->name('callback.instagram');

   // linkedin api
   Route::get('/oauth/redirect/linkedin', [LinkedController::class, 'redirect'])->name('connect.linkedin');
   Route::get('/oauth/callback/linkedin', [LinkedController::class, 'callback'])->name('callback.linkedin');

   // tiktok api
   Route::get('/oauth/redirect/tiktok', [TiktokController::class, 'redirect'])->name('connect.tiktok');
   Route::get('/oauth/callback/tiktok', [TiktokController::class, 'callback'])->name('callback.tiktok');
});

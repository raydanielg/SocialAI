<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cron', 'as' => 'cron.'], function () {

    Route::get('/notify-to-user', [App\Http\Controllers\CronController::class, 'notifyToUser']);

    Route::get('/refresh-platform-tokens', [App\Http\Controllers\CronController::class, 'refreshPlatformTokens']);
    Route::get('/dispatch-schedule-posts', [App\Http\Controllers\CronController::class, 'dispatchSchedulePosts']);
    Route::get('/cleanup-temp-post-data-files', [App\Http\Controllers\CronController::class, 'cleanupTemporaryBrandPostData']);

});

?>

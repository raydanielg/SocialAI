<?php

namespace App\Http\Controllers\Admin;

use App\Services\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class SystemController extends Controller
{
    public function clearCache()
    {
        Artisan::call('optimize:clear');
        Cache::flush();

        Toastr::success(__('Cache cleared successfully.'));

        return to_route('admin.dashboard');
    }
}

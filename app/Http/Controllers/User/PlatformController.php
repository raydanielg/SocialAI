<?php

namespace App\Http\Controllers\User;

use App\Helpers\PageHeader;
use App\Http\Controllers\Controller;
use App\Models\UserPlatform;
use Inertia\Inertia;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        PageHeader::set('Platforms');
        
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $platforms = activePlatforms()->filter()->keys();
        return Inertia::render('User/Platforms/Index', [
            'platforms' => $user->platforms,
            'activePlatforms' => $platforms,
        ]);
    }

    public function destroy(UserPlatform $platform)
    {
        $platform->delete();
        return back();
    }
}

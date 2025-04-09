<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Helpers\Toastr;
use App\Traits\Uploader;
use App\Helpers\PageHeader;
use Illuminate\Http\Request;
use App\Actions\OptionUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    use Uploader;


    public function __construct()
    {
        $this->middleware('permission:page-settings');
    }
    public function index()
    {
        Cache::flush();
        PageHeader::set('Page Settings');
        $primary_data = get_option('primary_data', true);
        $home_page = get_option('home_page', true);
        $about_page = get_option('about_page', true);
        $career_page = get_option('career_page', true);
        $contact_page = get_option('contact_page', true);
        $auth_pages = get_option('auth_pages', true);
        $service_page = get_option('service_page', true);
        $integration_page = get_option('integration_page', true);

        return Inertia::render('Admin/PageSetting/Index', [
            'primary_data' => $primary_data,
            'home_page' => $home_page,
            'about_page' => $about_page,
            'career_page' => $career_page,
            'contact_page' => $contact_page,
            'auth_pages' => $auth_pages,
            'service_page' => $service_page,
            'integration_page' => $integration_page,
        ]);
    }

    public function update(Request $request, $id)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        $request->validate([
            'socials.*' => ['nullable', 'url'],
            '*.*_link' => ['nullable', 'url'],
            '*.*.*_link' => ['nullable', 'url'],
            '*.*.*.*_link' => ['nullable', 'url'],
        ]);
        $optionUpdate = new OptionUpdate();
        $optionUpdate->update($id);

        Cache::flush();

        Toastr::success(__('Information has been updated.'));

        return back();
    }
}

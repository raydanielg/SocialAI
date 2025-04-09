<?php

namespace App\Http\Controllers\Admin\UserLogs;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Helpers\PageHeader;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index()
    {
        PageHeader::set(title: 'User Brands');

        $brands = Brand::query()
            ->filterOn(['name'])
            ->with(['user'])
            ->latest()
            ->paginate();

        $totalBrandCount = Brand::query()->count();
        $todaysBrandCount = Brand::query()->whereDate('created_at', today())->count();
        $lastThirtyDaysBrandCount = Brand::query()
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->count();

        return Inertia::render('Admin/UserLog/Brand/Index', [
            'brands' => $brands,
            'totalBrandCount' => $totalBrandCount,
            'todaysBrandCount' => $todaysBrandCount,
            'lastThirtyDaysBrandCount' => $lastThirtyDaysBrandCount,
        ]);
    }

    public function destroy(Brand $brand)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $brand->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}

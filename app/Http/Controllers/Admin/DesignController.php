<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Services\Toastr;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DesignController extends Controller
{
    use Uploader;
    public function __construct()
    {
        $this->middleware('permission:designs');
    }
    public function index()
    {
        $segments = request()->segments();
        $designs = Design::query()->paginate();
        return Inertia::render('Admin/Design/Index', [
            'designs' => $designs,
            'segments' => $segments,
        ]);
    }

    public function create()
    {
        $shapes = [];
        $dir = public_path('assets/shapes');
        $folders = array_diff(scandir($dir), ['.', '..']);
        foreach ($folders as $folder) {
            $path = $dir . '/' . $folder;
            if (is_dir($path)) {
                $files = array_diff(scandir($path), ['.', '..']);
                $shapes[$folder] = $files;
            }
        }

        return Inertia::render('Admin/Design/Create', [
            'shapes' => $shapes,
        ]);
    }

    public function edit(Design $design)
    {
        $shapes = [];
        $dir = public_path('assets/shapes');
        $folders = array_diff(scandir($dir), ['.', '..']);
        foreach ($folders as $folder) {
            $path = $dir . '/' . $folder;
            if (is_dir($path)) {
                $files = array_diff(scandir($path), ['.', '..']);
                $shapes[$folder] = $files;
            }
        }

        return Inertia::render('Admin/Design/Edit', [
            'design' => $design,
            'shapes' => $shapes,
        ]);
    }

    public function store(Request $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'placeholder' => 'required|string',
            'title' => 'required|string',
            'canvas' => 'required|json',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->filled('placeholder')) {
            $placeholder = $this->saveFileFromUrl($request->placeholder);
        }

        Design::create([
            'title' => $request->title,
            'placeholder' => $placeholder,
            'canvas' => json_decode($request->canvas),
            'status' => $request->status,
        ]);
        return to_route('admin.design.index')->with('success', 'Created Successfully');
    }

    public function update(Request $request, Design $design)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'placeholder' => 'required|string',
            'title' => 'required|string',
            'canvas' => 'required|json',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->filled('placeholder')) {
            $placeholder = $this->saveFileFromUrl($request->placeholder);
        }

        $design->update([
            'title' => $request->title,
            'placeholder' => $placeholder,
            'canvas' => json_decode($request->canvas),
            'status' => $request->status,
        ]);
        return to_route('admin.design.index')->with('success', 'Updated Successfully');
    }

    public function destroy(Design $design)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $design->delete();
        return to_route('admin.design.index')->with('danger', 'Deleted Successfully');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Inertia\Inertia;
use App\Services\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:menu');
    }
    public function index()
    {
        $menus = Menu::latest()->get();
        $languages = get_option('languages', true);

        $totalMenus =  Menu::count();
        $totalActiveMenus =  Menu::where('status', 1)->count();
        $totalDraftMenus =  Menu::where('status', 0)->count();

        $segments = request()->segments();

        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create Menu'),
                'url' => '#',
                'target' => '#addNewMenuDrawer',
            ]
        ];

        return Inertia::render('Admin/Menu/Index', compact('menus', 'languages', 'totalMenus', 'totalActiveMenus', 'totalDraftMenus', 'segments', 'buttons'));
    }

    public function store(Request $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'name'  => ['required'],
            'position' => ['required'],
            'status' => ['required'],
            'language' => ['required'],
        ]);

        if ($request->status == 1) {
            Menu::where('position', $request->position)
                ->where('lang', $request->lang)
                ->update(['status' => 0]);
        }

        $men = new Menu;
        $men->name = $request->name;
        $men->position = $request->position;
        $men->status = $request->status;
        $men->lang = $request->language;
        $men->data = "[]";
        $men->save();

        Toastr::success(__('Menu Created Successfully.'));

        return back();
    }

    public function updateData($id, Request $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $info = Menu::findOrFail($id);
        $info->data = $request->data;
        $info->save();

        Cache::forget('menu_' . $info->lang);
        return response()->json([
            'message'  => __('Menu Updated Successfully.')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): \Inertia\Response
    {
       
        $info = Menu::findOrFail($id);
        $contents = is_array($info->data) ? $info->data : [];

        $segments = request()->segments();

        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.menu.index')
            ]
        ];

        return Inertia::render('Admin/Menu/Show', compact('info', 'contents', 'segments', 'buttons'));
    }

    public function update(Request $request, $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        $request->validate([
            'name'  => 'required',
            'position' => 'required',
            'status' => 'required',
            'language' => 'required',
        ]);

        if ($request->status == 1) {
            Menu::where('position', $request->position)
                ->where('lang', $request->lang)
                ->update(['status' => 0]);
        }

        $menu = Menu::find($id);
        $menu->name = $request->name;
        $menu->position = $request->position;
        $menu->status = $request->status;
        $menu->lang = $request->language;
        $menu->save();

        Cache::forget($request->position . $request->language);

        Toastr::success(__('Menu Updated Successfully.'));

        return back();
    }

    public function destroy($id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return back();
    }
}

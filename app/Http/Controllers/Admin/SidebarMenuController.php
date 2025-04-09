<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SidebarMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:menu');
    }

    public function menuPath($pathName)
    {
        $menuPath = database_path("/json/{$pathName}.json");

        if (!File::exists($menuPath)) {
            throw new \Exception("Menu file not found for type: {$pathName}");
        }

        return $menuPath;
    }

    public function index(Request $request)
    {
        $segments = $request->segments();

        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create Menu'),
                'url' => '#',
                'target' => '#addNewMenuDrawer',
            ]
        ];

        $files = array_diff(scandir(database_path('json')), array('.', '..'));
        $list_of_menus = array_filter($files, function ($file) {
            return strpos($file, 'menu') !== false;
        });

        $menus = [];
        foreach ($list_of_menus as $key => $menu) {
            $menuKey = str_replace('.json', '', $menu);
            $menuFile = json_decode(File::get(database_path('json/' . $menu)), true);
            $menus[$menuKey] = collect($menuFile)->sortBy('order')->values()->all();
        }
        return Inertia::render('Admin/SidebarMenu/Index', [
            'menus' => $menus,
            'segments' => $segments,
            'buttons' => $buttons
        ]);
    }



    public function store(Request $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'heading' => 'required|string',
            'location' => 'required|string',
        ]);
        $menuPath = $this->menuPath($request->location);
        $menus = json_decode(File::get($menuPath), true);

        $maxOrder = collect($menus)->max('order');
        $newMenuItem = [
            "id" => Str::random(6),
            "heading" => $request->heading,
            "order" => $maxOrder + 1,
            "deletable" => true,
            "links" => []
        ];

        $menus[] = $newMenuItem;

        usort($menus, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });
        $menus = File::put($menuPath, json_encode($menus, JSON_PRETTY_PRINT));

        Cache::forget('menu_sidebar' . $request->location);

        return back()->with('success', 'Menu created successfully');
    }

    public function updateData($id, Request $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $path = $this->menuPath($request->location);
        $getMenus = json_decode(File::get($path), true);

        $menuIndex = collect($getMenus)->search(function ($item) use ($id) {
            return $item['id'] == $id;
        });
        if ($menuIndex === false) {
            return response()->json(['error' => 'Menu not found'], 404);
        }
        $getMenus[$menuIndex]['links'] = $request->data;

        File::put($path, json_encode($getMenus, JSON_PRETTY_PRINT));
        Cache::forget('menu_sidebar' . $request->location);
        return response()->json(['message' => 'Menu updated successfully']);
    }

    public function show($id, $location, Request $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $segments = $request->segments();

        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.sidebar-menu.index')
            ]
        ];
        $getMenus = json_decode(File::get($this->menuPath($location)), true);
        $menu = collect($getMenus)->where('id', $id)->first();
        $contents = isset($menu['links']) ? $menu['links'] : [];
        foreach ($contents as $key => $value) {
            if (!isset($contents[$key]['children'])) {
                $contents[$key]['children'] = [];
            }
        }
        return Inertia::render('Admin/SidebarMenu/Show', [
            'info' => $menu,
            'contents' => $contents,
            'segments' => $segments,
            'buttons' => $buttons,
            'location' => $location
        ]);
    }


    public function update(Request $request, $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        
        $request->validate([
            'heading' => 'required|string',
            'location' => 'required|string',
        ]);

        $menus = json_decode(File::get($this->menuPath($request->location)), true);

        $menuIndex = array_search($id, array_column($menus, 'id'));

        if ($menuIndex === false) {
            return back()->with('danger', 'Menu item not found');
        }

        $menus[$menuIndex]['heading'] = $request->heading;

        File::put($this->menuPath($request->location), json_encode($menus, JSON_PRETTY_PRINT));
        Cache::forget('menu_sidebar' . $request->location);
        return back()->with('success', 'Menu item updated successfully');
    }
    public function arrange(Request $request, $location)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $menus = json_decode(File::get($this->menuPath($location)), true);

        $request->validate([
            'items' => 'required|array',
        ]);

        $newOrders = collect($request->items)->keyBy('id');

        foreach ($menus as &$menu) {
            if (isset($newOrders[$menu['id']])) {
                $menu['order'] = $newOrders[$menu['id']]['order'];
            }
        }

        usort($menus, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        File::put($this->menuPath($location), json_encode($menus, JSON_PRETTY_PRINT));

        Cache::forget('menu_sidebar' . $location);

        return back()->with('success', 'Menu item updated successfully');
    }



    public function destroy($id, $location)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $menus = json_decode(File::get($this->menuPath($location)), true);

        $menuIndex = array_search($id, array_column($menus, 'id'));

        if ($menuIndex === false) {
            return back()->with('danger', 'Menu item not found');
        }

        $menuToDelete = $menus[$menuIndex];

        if (!isset($menuToDelete['deletable']) || $menuToDelete['deletable'] !== true) {
            return back()->with('danger', 'This menu item cannot be deleted');
        }
        unset($menus[$menuIndex]);

        $menus = array_values($menus);
        foreach ($menus as $index => $menu) {
            $menus[$index]['order'] = $index + 1;
        }

        File::put($this->menuPath($location), json_encode($menus, JSON_PRETTY_PRINT));
        Cache::forget('menu_sidebar' . $location);

        return back()->with('success', 'Menu item deleted successfully');
    }
}

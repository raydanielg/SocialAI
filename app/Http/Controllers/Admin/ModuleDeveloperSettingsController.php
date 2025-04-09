<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PageHeader;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Nwidart\Modules\Facades\Module;
use ZipArchive;

class ModuleDeveloperSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:developer-settings');
    }

    public function index()
    {
        PageHeader::set('Modules List', buttons: [
            [
                'name' => __('Upload new module'),
                'url' => route('admin.module-developer-settings.show', 'module-settings')
            ]
        ]);

        $moduleLists = array_values(Module::toCollection()->toArray());

        foreach ($moduleLists as $key => $value) {
            $module = Module::find($value['name']);
            $moduleLists[$key]['enabled'] = $module->isEnabled();
        }

        return Inertia::render('Admin/Developer/ModuleList', [
            'modules_nodes' => $moduleLists ?? [],
        ]);
    }

    public function show($id)
    {
        if ($id !== 'module-settings') {
            return back()->with('error', 'Page not found');
        }
        PageHeader::set('Modules List', buttons: [
            [
                'name' => __('Back to dashboard'),
                'url' => url('/admin/dashboard')
            ]
        ]);
        return Inertia::render('Admin/Developer/Module', [
            'id' => $id,
        ]);
    }

    public function store(Request $request)
    {

        if (env('DEMO_MODE')) {
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        $request->validate([
            'module'  => ['required', 'mimes:zip'],
            'purchase_key' => ['required'],

        ]);

        if (!class_exists('ZipArchive')) {
            return response()->json(['message' => 'Enable php ZipArchive extension in your server'], 403);
        }

        $checkArr = explode('-', $request->purchase_key);

        if (count($checkArr) != 5) {
            return response()->json(['message' => 'The purchase key is invalid'], 403);
        }

        $body['purchase_key'] = $request->purchase_key;
        $body['url'] = url('/');

        $response =  Http::post('https://api.thedevstation.com/api/verify', $body);
        if ($response->status() != 200) {
            $response = json_decode($response->body());

            return back()->with('danger', $response->message);
        }

        $response = json_decode($response->body());
        $response_files = $response->queries ?? [];


        ini_set('max_execution_time', '0');

        //---------------------
        // Get the uploaded file
        $uploadedFile = $request->file('module');

        // Define a unique name for the uploaded file to store
        $fileName = time() . '-' . $uploadedFile->getClientOriginalName();

        $filePath = $uploadedFile->move('temp', $fileName);

        // Initialize the ZipArchive object
        $zip = new ZipArchive;

        // Try to open the zip file
        $zip->open($filePath);
        $its_valid = false;


        $firstFolder = null;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $row = $zip->statIndex($i);
            $fileName = $row['name'];

            // Check for module.json file
            if (basename($fileName) == 'module.json') {
                $its_valid = true;
            }

            // Check if it's a folder
            if (substr($fileName, -1) == '/' && $firstFolder == null) {
                $firstFolder = $fileName; // Store the first folder name

            }
        }

        $firstFolder = str_replace('/', '', $firstFolder);

        if (!$its_valid && $firstFolder == null) {
            return response()->json(['message' => 'This Module Is Invalid'], 403);
        }

        $extracted = $zip->extractTo(base_path('modules'));
        $zip->close();
        unlink($filePath);


        $moduleSourcePath = base_path('modules/' . $firstFolder);
        $module_json = json_decode(file_get_contents($moduleSourcePath . '/module.json'));


        $module_json->module_key  = $request->purchase_key;


        File::put($moduleSourcePath . '/module.json', json_encode($module_json, JSON_PRETTY_PRINT));
        // for build folder
        $buildFolder =  'build-' . strtolower($firstFolder);
        $buildSourcePath = $moduleSourcePath . '/' . $buildFolder;
        if (File::isDirectory($buildSourcePath)) {
            $buildDestinationPath = public_path($buildFolder);
            if (File::isDirectory($buildDestinationPath)) {
                File::deleteDirectory($buildDestinationPath);
            }
            File::moveDirectory($buildSourcePath, $buildDestinationPath, true);

            File::deleteDirectory($buildSourcePath);
        }
        $this->setModuleMenu($module_json);
        foreach ($response_files ?? [] as $key => $row) {
            if ($row->type == 'file') {
                $fileData = Http::get($row->file);
                $fileData = $fileData->body();

                File::put(base_path($row->path), $fileData);
            } elseif ($row->type == 'folder') {
                $path = $row->path . '/' . $row->name;

                if (!File::exists(base_path($path))) {
                    File::makeDirectory(base_path($path), 0777, true, true);
                }
            } elseif ($row->type == 'command') {
                Artisan::call($row->command);
            } elseif ($row->type == 'query') {
                DB::statement($row->name);
            } else {
                eval($row->name);
            }
        }

        return to_route('admin.module-developer-settings.index')->with('success', 'Module Updated Successfully');
    }

    public function versionView($id)
    {
        if (env('DEMO_MODE')) {
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        PageHeader::set('Modules Update', buttons: [
            [
                'name' => __('Upload new module'),
                'url' => route('admin.module-developer-settings.show', 'module-settings')
            ]
        ]);

        abort_if(!file_exists(base_path('modules/' . $id) . '/module.json'), 404);
        $module_json = json_decode(file_get_contents(base_path('modules/' . $id) . '/module.json'));

        return Inertia::render('Admin/Developer/ModuleUpdate', [
            'module_json' => $module_json,
            'updateData' => [
                $id => Session::get('update-data-' . $id)
            ]
        ]);
    }

    public function edit($id)
    {
        if (env('DEMO_MODE')) {
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        abort_if(!file_exists(base_path('modules/' . $id) . '/module.json'), 404);
        $module_json = json_decode(file_get_contents(base_path('modules/' . $id) . '/module.json'));

        if ($module_json->status == true) {
            $module_json->status  = false;
        } else {
            $module_json->status  = true;
        }

        File::put(base_path('modules/' . $id) . '/module.json', json_encode($module_json, JSON_PRETTY_PRINT));


        return response()->json([
            'redirect' => route('admin.modules.index'),
            'message'  => __('Modules Status Updated.')
        ]);
    }


    public function updateModulesCheck(Request $request, $id)
    {

        if (env('DEMO_MODE')) {
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        abort_if(!file_exists(base_path('modules/' . $id) . '/module.json'), 404);
        $module_json = json_decode(file_get_contents(base_path('modules/' . $id) . '/module.json'));

        $site_key = $module_json->module_key;
        $body['purchase_key'] = $site_key;
        $body['url'] = url('/');
        $body['current_version'] = $module_json->version;

        $response =  Http::post('https://api.thedevstation.com/api/check-update', $body);
        $body = json_decode($response->body());

        if ($response->status() != 200) {
            return back()->with('danger', $body->message);
        }

        Session::put('update-data-' . $id, [
            'message' => $body->message,
            'version' => $body->version
        ]);
        return back()->with('info', 'New version is available!');
    }

    public function update(Request $request, $id)
    {

        if (env('DEMO_MODE')) {
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        abort_if(!file_exists(base_path('modules/' . $id) . '/module.json') && !Session::has('update-data-' . $id), 404);
        $module_json = json_decode(file_get_contents(base_path('modules/' . $id) . '/module.json'));

        $site_key = $module_json->module_key;
        $version = Session::get('update-data-' . $id)['version'];
        $body['purchase_key'] = $site_key;
        $body['url'] = url('/');
        $body['version'] = $version;

        $response =  Http::post('https://api.thedevstation.com/api/pull-update', $body);
        $response = json_decode($response->body());

        foreach ($response->updates ?? [] as $key => $row) {
            if ($row->type == 'file') {
                $fileData = Http::get($row->file);
                $fileData = $fileData->body();

                File::put(base_path($row->path), $fileData);
            } elseif ($row->type == 'folder') {
                $path = $row->path . '/' . $row->name;

                if (!File::exists(base_path($path))) {
                    File::makeDirectory(base_path($path), 0777, true, true);
                }
            } elseif ($row->type == 'command') {
                Artisan::call($row->command);
            } elseif ($row->type == 'query') {
                DB::statement($row->name);
            } else {
                eval($row->name);
            }
        }
        $module_json->version  = $version;

        File::put(base_path('modules/' . $id) . '/module.json', json_encode($module_json, JSON_PRETTY_PRINT));

        Session::forget('update-data-' . $id);
        Session::flash('success', 'Successfully updated to ' . $version);

        return back()->with('info', 'Successfully updated to v' . $version);
    }
    public function changeStatus(Request $request)
    {
        if (env('DEMO_MODE')) {
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }

        $module = Module::find($request->module);
        if (!$module) {
            return back()->with('error', 'Module not found');
        }

        match ($request->status) {
            'enable' => $module->enable(),
            'disable' => $module->disable()
        };
        $isEnabled = $module->isEnabled();

        // Get all menu types from the module
        $moduleMenus = collect($module->get('menu'));

        // Process menus for each menu type
        $menuTypes = $moduleMenus->pluck('menu_type')->unique();

        foreach ($menuTypes as $menuType) {
            $menuPath = database_path("/json/{$menuType}_menu.json");

            // Ensure the JSON file exists
            if (!File::exists($menuPath)) {
                File::put($menuPath, json_encode([], JSON_PRETTY_PRINT));
            }

            // Read existing menus
            $menusList = json_decode(File::get($menuPath), true);

            $typeSpecificMenus = $moduleMenus->where('menu_type', $menuType);

            foreach ($typeSpecificMenus as $moduleMenu) {
                if ($isEnabled) {
                    $exists = collect($menusList)->contains('id', $moduleMenu['id']);
                    if (!$exists) {
                        $menusList[] = $moduleMenu;
                    }
                } else {
                    $menusList = array_filter($menusList, function ($item) use ($moduleMenu) {
                        return $item['id'] !== $moduleMenu['id'];
                    });
                    $menusList = array_values($menusList);
                }
            }

            File::put($menuPath, json_encode($menusList, JSON_PRETTY_PRINT));

            // Clear cache for this menu type
            Cache::forget('menu_sidebar' . $menuType . '_menu');
        }

        return Inertia::location(route('admin.module-developer-settings.index'));
    }
    public function setModuleMenu($module_json)
    {

        if (env('DEMO_MODE')) {
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }

        try {
            $moduleMenus = $module_json?->menu ?? [];
            if (empty($moduleMenus)) return;
            foreach ($moduleMenus as $menuConfig) {
                $menuType = $menuConfig->menu_type ?? null;
                if (!$menuType) {
                    throw new \Exception("Menu type not found in {$menuType}_menu.json");
                }

                $jsonFilePath = database_path("/json/{$menuType}_menu.json");

                $existingMenuData = [];
                if (File::exists($jsonFilePath)) {
                    $existingMenuData = json_decode(File::get($jsonFilePath), true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        throw new \Exception("Invalid JSON in {$menuType}_menu.json");
                    }
                }

                $exists = collect($existingMenuData)->contains('id', $menuConfig->id);
                if (!$exists) {
                    unset($menuConfig->menu_type);
                    $existingMenuData[] = $menuConfig;
                }

                usort($existingMenuData, function ($a, $b) {
                    return ($a->order ?? 0) <=> ($b->order ?? 0);
                });

                Cache::forget('menu_sidebar' . $menuType . '_menu');
                File::put($jsonFilePath, json_encode($existingMenuData, JSON_PRETTY_PRINT));
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

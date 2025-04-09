<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;

class MenuService
{

    public static function defaultSeeder($menuType = 'admin')
    {
        try {
            $activeModules = collect(Module::allEnabled())->map(function ($module) {
                return ['name' => $module->getLowerName(), 'enabled' => $module->isEnabled()];
            })->keys();

            $moduleMenus = [];
            foreach ($activeModules as $module) {
                $moduleMenu = collect(Module::find($module)->get('menu'))
                    ->where('menu_type', $menuType)->first();
                if ($moduleMenu) {
                    $moduleMenus[] = $moduleMenu;
                }
            }

            $menuFilePath = resource_path("js/Layouts/{$menuType}/menu.json");
            if (!File::exists($menuFilePath)) {
                throw new \Exception("Menu file not found for type: {$menuType}");
            }

            $getFile = json_decode(File::get($menuFilePath), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON in menu file for type: {$menuType}");
            }

            $combinedMenuData = array_merge($getFile, $moduleMenus);
            $combinedMenuData = collect($combinedMenuData)->values()->all();

            $newFilePath = database_path("/json/{$menuType}_menu.json");
            File::put($newFilePath, json_encode($combinedMenuData, JSON_PRETTY_PRINT));

            return true;
        } catch (\Exception $e) {
            \Log::error("Error in defaultSeeder: " . $e->getMessage());
            throw $e;
        }
    }

    public static function getMenu($menuType = 'admin')
    {
        $menuFilePath = database_path("/json/{$menuType}_menu.json");
        if (!File::exists($menuFilePath)) {
            throw new \Exception("Menu file not found for type: {$menuType}");
        }
        $menuFile = json_decode(File::get($menuFilePath), true);
        return collect($menuFile)->sortBy('order', SORT_NATURAL,)->values()->all();
    }
}

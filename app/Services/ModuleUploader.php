<?php

namespace App\Services;

use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ModuleUploader
{
    private $tempPath;
    public $purchaseKey;

    public function __construct($purchaseKey)
    {
        $this->tempPath = public_path('temp');
        $this->purchaseKey = $purchaseKey;
    }

    public function uploadAndInstall(UploadedFile $zipFile)
    {
        $this->isDirectoryExists($this->tempPath);

        $filename = 'module_' . time() . '.zip';
        $zipPath = $this->tempPath . '/' . $filename;

        if (!$zipFile->move($this->tempPath, $filename)) {
            throw new \Exception('Failed to move the uploaded file.');
        }

        try {
            $this->extractAndInstallModule($zipPath);
        } finally {
            File::delete($zipPath);
        }

        return true;
    }

    private function extractAndInstallModule($zipPath)
    {
        $zip = new ZipArchive;
        $extractPath = $this->tempPath . '/extract_' . time();

        $this->isDirectoryExists($extractPath);

        $result = $zip->open($zipPath);

        if ($result !== TRUE) {
            throw new \Exception('Failed to open the zip file. Error code: ' . $result);
        }

        $zip->extractTo($extractPath);
        $zip->close();

        $this->moveModuleFolder($extractPath);

        File::deleteDirectory($extractPath);
    }

    private function moveModuleFolder($extractPath)
    {
        $moduleFolders = File::directories($extractPath);

        if (empty($moduleFolders)) {
            throw new \Exception('No module folder found in the zip file.');
        }

        $moduleFolder = basename($moduleFolders[0]);
        $sourcePath = $extractPath . '/' . $moduleFolder;
        $destinationPath = base_path('Modules/' . $moduleFolder);

        $buildFolder = public_path('build-' . strtolower($moduleFolder));
        $buildSourcePath = $sourcePath . $buildFolder;
        if (File::isDirectory($buildSourcePath)) {
            $buildDestinationPath = public_path($buildFolder);
            if (File::isDirectory($buildDestinationPath)) {
                File::deleteDirectory($buildDestinationPath);
            }
            // Create the destination directory if it doesn't exist
            $this->isDirectoryExists($buildDestinationPath);
            File::moveDirectory($buildSourcePath, $buildDestinationPath, true);

            File::deleteDirectory($buildSourcePath);
        }
        // Move the module folder to the Modules directory
        File::moveDirectory($sourcePath, $destinationPath, true);
        $this->afterModuleInstalled($moduleFolder);
        File::deleteDirectory(public_path('temp'));
    }

    private function isDirectoryExists($path)
    {
        if (!File::isDirectory($path)) {
            if (!File::makeDirectory($path, 0755, true)) {
                throw new \Exception("Failed to create directory: $path");
            }
        }
    }


    public function afterModuleInstalled($name)
    {
        Module::find($name)->enable();
        $path = base_path('Modules/' . $name . '/module.json');
        $module = json_decode(File::get($path), true);
        $module['purchase_key'] = $this->purchaseKey;
        File::put($path, json_encode($module, JSON_PRETTY_PRINT));
        $this->setModuleMenu($name);
    }


    public function setModuleMenu($name)
    {
        try {
            $module = Module::find($name);

            $moduleMenus = $module->get('menu', []);

            foreach ($moduleMenus as $menuConfig) {
                $menuType = $menuConfig['menu_type'] ?? null;
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

                $exists = collect($existingMenuData)->contains('id', $menuConfig['id']);
                if (!$exists) {
                    unset($menuConfig['menu_type']);
                    $existingMenuData[] = $menuConfig;
                }

                usort($existingMenuData, function ($a, $b) {
                    return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
                });

                File::put($jsonFilePath, json_encode($existingMenuData, JSON_PRETTY_PRINT));
            }


            return true;
        } catch (\Exception $e) {
            \Log::error("Error in setModuleMenu: " . $e->getMessage());
            throw $e;
        }
    }
}

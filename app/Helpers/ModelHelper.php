<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Stringable;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

trait ModelHelper
{

    //  automatic tasks for model
    // 1. generate uuid,
    // 2. generate username,
    // 3. upload and store files,
    // 4. upload and update files,
    // 5. remove attached files

    abstract public function modelHelperConfig(): ModelHelperConfig;

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Model $model) {
            $config = $model->modelHelperConfig()->getConfig();

            // uuid
            if ($config['uuid'] && !$model->getAttribute('uuid')) {
                $model->setAttribute('uuid', Str::uuid()->toString());
            }

            // invoice
            if ($config['invoice_no'] && !$model->getAttribute('invoice_no')) {
                $nextModelId = self::max('id') + 1;
                $model->setAttribute('invoice_no', str_pad($nextModelId, 7, '0', STR_PAD_LEFT));
            }

            // username
            if ($config['username'] && !$model->getAttribute('username')) {
                $usernameConfig = $config['username'];
                $username = Str::of(is_array($usernameConfig) ? implode('', $usernameConfig) : $usernameConfig)
                    ->trim()
                    ->snake()
                    ->whenContains('@', function (Stringable $str) {
                        return $str->before('@');
                    })
                    ->limit(16, '');

                /**
                 * @var self $model
                 */
                $model->setAttribute('username', $model->generateUnique('username', $username, '_'));
            }

            // slug
            if ($config['slug'] && !$model->getAttribute('slug')) {
                $slug = Str::slug($model->{$config['slug']});
                $model->setAttribute('slug', $model->generateUnique('slug', $slug, '-'));
            }

            // files
            foreach ($config['files'] as $key) {
                if (env('DEMO_MODE')) return;
                $value = $model->getAttribute($key);
                $isUpdating = boolval($model->getAttribute('id'));

                if ($value instanceof UploadedFile) {
                    $model->removeFileIfExists($key, true);
                    $fileUrl = $model->uploadFile($value);
                    $model->setAttribute($key, Storage::url($fileUrl));
                } elseif (!boolval($value) && $isUpdating) {
                    $val = $model->getOriginal($key);
                    if ($val === false) {
                        $val = "";
                    }
                    $model->setAttribute($key, $model->getOriginal($key));
                }
            }
        });

        static::deleting(function ($model) {
            $model->removeAttachedFiles();
        });
    }

    protected function uploadFile(UploadedFile $file)
    {
        $ext = $file->extension();
        $filename = Str::random(20) . '.' . $ext;
        $path = '/uploads' . date('/y') . '/' . date('m') . '/';

        if (env('APP_ENV') == 'demo') {
            $path = '/demo/';
        }

        $filePath = $path . $filename;
        Storage::put($filePath, file_get_contents($file));
        return $filePath;
    }

    protected function removeFileIfExists($key, $parse = false): bool
    {
        $fileUrl = $this->getOriginal($key);

        if ($fileUrl) {
            if ($parse)
                $fileUrl = parse_url($fileUrl, PHP_URL_PATH);
            if (Storage::exists($fileUrl)) {
                return Storage::delete($fileUrl);
            }
        }
        return false;
    }

    protected function removeAttachedFiles(?array $args = null): bool
    {
        $modelFileAttrs = $args ?? $this->getModelHelperConfig('files');

        $fails = [];
        foreach ($modelFileAttrs as $key) {
            if (!$this->removeFileIfExists($key, true)) {
                array_push($fails, $key);
            }
        }
        return count($fails) == 0;
    }

    protected function deleteWith(...$args): bool
    {
        return $this->removeAttachedFiles($args) && $this->delete();
    }

    protected function getModelHelperConfig(?string $key = null)
    {
        if ($key) {
            return $this->modelHelperConfig()->getConfig($key) ?? null;
        }

        return $this->modelHelperConfig();
    }

    protected function getModelHelperKeyExists($key): bool
    {
        return array_key_exists($key, $this->setModelHelper());
    }

    protected function generateUnique(string $column, string|array $value, string $separator = '-')
    {
        $value = is_array($value) ? implode($separator, $value) : $value;
        $count = 1;

        while (static::where($column, $value)->exists()) {
            $value = $value . $separator . $count;
            $count++;
        }

        return $value;
    }
}

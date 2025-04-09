<?php

namespace App\Helpers;

class SeoMeta
{
    public static function init(
        string $option_key,
        bool $locale = true
    ): array {
        $seo = (array) get_option($option_key, $locale);
        self::set($seo);
        return self::get();
    }

    public static function set(string|array $key, ?string $value = null)
    {
        app()->booted(function () use ($key, $value) {
            if (is_array($key)) {
                config(['seometa' => $key]);
            } else {
                config()->set('seometa.' . $key, $value);
                config()->set('seometa.' . $key, $value);
            }
        });

        return static::get();
    }

    public static function patch(array $data)
    {
        foreach ($data as $key => $value) {
            self::set($key, $value);
        }
        return static::get();
    }

    public static function get(?string $key = null)
    {
        if ($key) {
            return config('seometa.' . $key);
        }

        return config('seometa') ?? [];
    }

    public static function clear(?string $key = null)
    {
        if ($key) {
            self::set($key, null);
        }

        return static::get();
    }
}

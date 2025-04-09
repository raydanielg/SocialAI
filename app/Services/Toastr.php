<?php

namespace App\Services;

class Toastr
{
    const KEYS = ['success', 'warning', 'danger', 'info'];

    public static function success(string $message)
    {
        return static::setToast('success', $message);
    }

    public static function warning(string $message)
    {
        return static::setToast('warning', $message);
    }

    public static function danger(string $message)
    {
        return static::setToast('danger', $message);
    }

    public static function error(string $message)
    {
        return static::setToast('danger', $message);
    }

    public static function info(string $message)
    {
        return static::setToast('info', $message);
    }

    public static function setToast(string $key, string $message)
    {
        if (!in_array($key, self::KEYS)) {
            return;
        }

        if (session()->has($key)) {
            $oldValue = session()->get($key);

            if (!is_array($oldValue)) {
                $oldValue = [$oldValue];
            }
            array_push($oldValue, $message);
            session()->flash($key, $oldValue);
        } else {
            session()->flash($key, $message);
        }
    }



    public static function Toast()
    {
        return array_reduce(self::KEYS, function ($array, $key) {
            if (request()->session()->has($key)) {
                $array[$key] = request()->session()->get($key);
            }
            return $array;
        }, []);
    }
}

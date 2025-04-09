<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    public function update($locale)
    {
        session()->put('locale', $locale);
        app()->setLocale($locale);
        return inertia()->location(url()->previous());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LanguageSwitcherController extends Controller
{
    public function setLanguage(Request $request, $language)
    {
        app()->setLocale($language);
        Cookie::queue('language', $language, 60 * 24 * 365);
        return redirect()->back();
    }
}

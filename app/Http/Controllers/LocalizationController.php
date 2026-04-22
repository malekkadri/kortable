<?php

namespace App\Http\Controllers;

use App\Support\Localization\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        abort_unless(Locale::isSupported($locale), 404);

        session()->put('locale', $locale);

        $to = url()->previous();
        $localePattern = implode('|', Locale::all());

        if (preg_match('#/('.$localePattern.')(/|$)#', $to)) {
            $to = preg_replace('#/('.$localePattern.')(/|$)#', '/'.$locale.'$2', $to, 1);
        } else {
            $to = route('front.home', ['locale' => $locale]);
        }

        return redirect()->to($to);
    }
}

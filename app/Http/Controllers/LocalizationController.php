<?php

namespace App\Http\Controllers;

use App\Support\Localization\Locale;
use Illuminate\Http\RedirectResponse;

class LocalizationController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        abort_unless(Locale::isSupported($locale), 404);

        session()->put('locale', $locale);

        $to = url()->previous();

        if (preg_match('#/(fr|ar|en)(/|$)#', $to)) {
            $to = preg_replace('#/(fr|ar|en)(/|$)#', '/'.$locale.'$2', $to, 1);
        } else {
            $to = route('front.home', ['locale' => $locale]);
        }

        return redirect()->to($to);
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('front.home', [
            'page' => Page::published()->where('slug', 'home')->first(),
            'services' => Service::active()->get(),
            'testimonials' => Testimonial::active()->get(),
            'siteSetting' => SiteSetting::first(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('front.home', [
            'homeSections' => HomeSection::active()->get(),
            'featuredProjects' => Project::query()->published()->featured()->ordered()->take(6)->get(),
            'services' => Service::active()->get(),
            'testimonials' => Testimonial::active()->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ModuleController extends Controller
{
    public function index(): View
    {
        return view('admin.modules.index', [
            'modules' => config('kortable.modules'),
        ]);
    }
}

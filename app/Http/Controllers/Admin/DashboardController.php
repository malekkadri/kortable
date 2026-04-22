<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'projects' => Project::count(),
                'pages' => Page::count(),
                'services' => Service::count(),
                'unread_messages' => ContactMessage::where('status', 'new')->count(),
            ],
        ]);
    }
}

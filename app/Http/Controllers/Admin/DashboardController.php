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
        $latestMessages = ContactMessage::query()
            ->latest()
            ->limit(5)
            ->get();

        $latestPublishedProjects = Project::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $recentActivity = collect()
            ->merge(
                Project::query()->latest('updated_at')->limit(4)->get()->map(function (Project $project) {
                    return [
                        'type' => 'project',
                        'title' => $project->title['en'] ?? $project->slug,
                        'timestamp' => $project->updated_at,
                        'action' => $project->created_at?->equalTo($project->updated_at) ? 'created' : 'updated',
                    ];
                })
            )
            ->merge(
                Page::query()->latest('updated_at')->limit(4)->get()->map(function (Page $page) {
                    return [
                        'type' => 'page',
                        'title' => $page->title['en'] ?? $page->slug,
                        'timestamp' => $page->updated_at,
                        'action' => $page->created_at?->equalTo($page->updated_at) ? 'created' : 'updated',
                    ];
                })
            )
            ->merge(
                Service::query()->latest('updated_at')->limit(4)->get()->map(function (Service $service) {
                    return [
                        'type' => 'service',
                        'title' => $service->title['en'] ?? $service->slug,
                        'timestamp' => $service->updated_at,
                        'action' => $service->created_at?->equalTo($service->updated_at) ? 'created' : 'updated',
                    ];
                })
            )
            ->sortByDesc('timestamp')
            ->take(8)
            ->values();

        return view('admin.dashboard', [
            'stats' => [
                'total_projects' => Project::count(),
                'featured_projects' => Project::featured()->count(),
                'published_pages' => Page::published()->count(),
                'active_services' => Service::active()->count(),
                'unread_messages' => ContactMessage::where('status', ContactMessage::STATUS_NEW)->count(),
            ],
            'latestMessages' => $latestMessages,
            'latestPublishedProjects' => $latestPublishedProjects,
            'recentActivity' => $recentActivity,
        ]);
    }
}

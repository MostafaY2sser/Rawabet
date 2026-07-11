<?php

namespace App\Http\Controllers\Customer;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $base = Project::where('customer_id', auth('customer')->id());
        $allProjects = (clone $base)->count();
        $completedProjects = (clone $base)->where('status', ProjectStatus::COMPLETED->value)->count();
        $inProgressProjects = (clone $base)->where('status', ProjectStatus::IN_PROGRESS->value)->count();
        $cancelledProjects = (clone $base)->where('status', ProjectStatus::CANCELLED->value)->count();

     
        $list = clone $base;

        if ($request->filled('project_search')) {
            $s = $request->project_search;
            $list->where(function ($q) use ($s) {
                $q->where('work_description', 'like', "%{$s}%")
                    ->orWhereHas('serviceType', fn($q) => $q->where('name', 'like', "%{$s}%"))
                    ->orWhereHas('buildingType', fn($q) => $q->where('name', 'like', "%{$s}%"))
                    ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$s}%"))
                        ->orWhereHas('city', fn($q) => $q->where('name', 'like', "%{$s}%"))
                    ->orWhereHas('region', fn($q) => $q->where('name', 'like', "%{$s}%"));
            });
        }

        if ($request->filled('project_filter') && $request->project_filter !== 'all') {
            $list->where('status', $request->project_filter);
        }

        $projects = $list->latest()->get();

        return view('customer.dashboard', [
            'projects' => $projects,
            'projectsCount' => $projects->count(),
            'allProjects' => $allProjects,
            'completedProjects' => $completedProjects,
            'inProgressProjects' => $inProgressProjects,
            'cancelledProjects' => $cancelledProjects,
            'filter' => $request->project_filter ?? 'all',
            'search' => $request->project_search ?? '',
        ]);
    }


}

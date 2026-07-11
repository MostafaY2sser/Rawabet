<?php

namespace App\Http\Controllers\Provider\Project;

use App\Enums\OfferStatus;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Project;
use App\Models\ProjectAttachment;
use App\Models\Provider;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth('provider')->id();

        $provider = Provider::find($userId);

        // Get provider's work region IDs (from the pivot table)
        $workRegionIds = $provider->workRegions()->pluck('regions.id')->toArray();

        $projectsQuery = Project::where('status', ProjectStatus::OPEN_FOR_OFFERS->value)
            ->whereDoesntHave('offers', function ($query) use ($userId) {
                $query->where('provider_id', $userId);
            })
            ->where(function ($query) use ($userId) {
                $query->whereDoesntHave('scopedProviders')
                    ->orWhereHas('scopedProviders', function ($scopeQuery) use ($userId) {
                        $scopeQuery->where('providers.id', $userId);
                    });
            });

        // Get distinct cities (if needed)
        $cities = City::where("status" , 1)->get();

        // Clone the query to avoid side effects and order by budget
        $budgets = (clone $projectsQuery)
            ->orderBy('budget', 'asc')
            ->pluck('budget')
            ->unique()
            ->values();

        // Apply city filter (if provided)
        if (!empty($request->city)) {
            $projectsQuery->where('city_id', $request->city);
        }

        // Apply exact budget filter (if provided)
        if (!empty($request->budget)) {
            $projectsQuery->where('budget', $request->budget);
        }

        if (!empty($request->speciality)) {
            $projectsQuery->where('service_type', $request->speciality);
        }

        $specialites = Speciality::all();
        // Apply search text on work description (if provided)
        if (!empty($request->search)) {
            $projectsQuery->where('work_description', 'LIKE', '%' . $request->search . '%');
        }

        $projects = $projectsQuery->get();
        return view('provider.project.index', compact('projects', 'cities', 'budgets', 'specialites'));
    }

    public function inProgressProjects(Request $request)
    {
        $userId = auth('provider')->id();

        $projectsQuery = Project::where('status', ProjectStatus::IN_PROGRESS->value)
            ->whereHas('offers', function ($query) use ($userId) {
                $query->where('provider_id', $userId)->where('status', OfferStatus::ACCEPTED->value);  // or just 'active' if not using enum
            });

        // Get distinct cities (if needed)
        $cities = City::where("status" , 1)->get();

        // Clone the query to avoid side effects and order by budget
        $budgets = (clone $projectsQuery)
            ->orderBy('budget', 'asc')
            ->pluck('budget')
            ->unique()
            ->values();

        // Apply city filter (if provided)
        if (!empty($request->city)) {
            $projectsQuery->where('city_id', $request->city);
        }

        // Apply exact budget filter (if provided)
        if (!empty($request->budget)) {
            $projectsQuery->where('budget', $request->budget);
        }

        if (!empty($request->speciality)) {
            $projectsQuery->where('service_type', $request->speciality);
        }

        $specialites = Speciality::all();
        // Apply search text on work description (if provided)
        if (!empty($request->search)) {
            $projectsQuery->where('work_description', 'LIKE', '%' . $request->search . '%');
        }

        $projects = $projectsQuery->get();
        return view('provider.project.in-progress', compact('projects', 'specialites', 'cities', 'budgets'));
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $attachments = [];

        foreach (config('project.files') as $type) {
            if(in_array($type['name'] , config('project.viewable_files_for_provider'))){            
            $attachments[$type['label']] = $project->attachments()->where('file_name', $type['name'])->get();
            }
        }
        return view('provider.project.show.index', compact('project', 'attachments'));
    }

     public function downloadFile($id)
    {
        $file = ProjectAttachment::findOrFail($id);

        // if ($file->project->customer_id != auth()->user()->id)
        //     abort(404);

        $filePath = $file->file_path;

    
        if (!Storage::disk('private_files')->exists($filePath) || !in_array($file->file_name , config('project.viewable_files_for_provider'))) {
            abort(404);
        }

        return Storage::disk('private_files')->download($filePath);
    }
}

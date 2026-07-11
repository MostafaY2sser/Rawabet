<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BuildingType;
use App\Models\Project;
use App\Models\Region;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function List(Request $request)
    {
        $projectQuery = Project::where('status', 'open_for_offers');
        $regions =Region::all();

        $buildingTypes = BuildingType::whereIn('id', Project::pluck('building_type'))->get();
        if ($request->filled('region')) {
            $projectQuery->where('region_id', $request->region);
        }

        if ($request->filled('building_type')) {
            $projectQuery->where('building_type', $request->building_type);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $projectQuery->where(function ($query) use ($keyword) {
                $query->where('work_description', 'like', '%' . $keyword . '%');
            });
        }

    
        $projects = $projectQuery->paginate(2); 
        $items = $projects->items();

        return view('site.projects.list', compact('projects', 'items', 'regions', 'buildingTypes'));
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('site.projects.details', compact('project'));
    }
}

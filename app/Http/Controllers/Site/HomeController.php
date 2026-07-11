<?php

namespace App\Http\Controllers\Site;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Provider;
use App\Models\ProjectType;
class HomeController extends Controller
{
    public function index(){
        $projects = Project::where('status', '<>', ProjectStatus::REQUIRE_COMPLETE->value)->get();

        $projectTypes = ProjectType::withCount('projects')->get();
        $providers = Provider::with('specializations')->get();

        return view("site.home",compact('projects' , 'providers' ,'projectTypes'));
       
    }

}

<?php

namespace App\Http\Controllers\Provider;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::all();
        return view("provider.project.index",compact("projects"));
    }
}

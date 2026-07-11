<?php

namespace App\Http\Controllers\Admin\Project;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\Admin\ProjectReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $reportService;

    //
    public function __construct(ProjectReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function create($id)
    {
        if (!Auth::user('admin')->can('create projects.workReports'))
            abort(403);
        $project = Project::find($id);
        if ($project->status != ProjectStatus::IN_PROGRESS->value)
            abort(404);
        return view('admin.projects.reports.create', compact('project'));
    }

    public function store(Request $request, $id)
    {
        if (!Auth::user('admin')->can('create projects.workReports'))
            abort(403);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpg,jpeg,png,pdf'
        ]);

        $project = Project::find($id);
        if ($project->status != ProjectStatus::IN_PROGRESS->value)
            abort(404);

        $attachemnts = $request->images;

        $data = $request->except('images');

        $data['project_id'] = $id;

        $this->reportService->store($data, $attachemnts);
        return redirect()->route('admin.projects.active.workstages', $project->id)->with('success', 'تم إنشاء التقرير بنجاح.');
    }
}

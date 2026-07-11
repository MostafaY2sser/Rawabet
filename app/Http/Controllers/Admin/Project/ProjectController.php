<?php

namespace App\Http\Controllers\Admin\Project;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Project;
use App\Models\ProjectAttachment;
use App\Models\Provider;
use App\Utils\NotificationUtility;
use App\Utils\OfferUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(\App\Services\Admin\ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function pendingProjects(Request $request)
    {
        if (!Auth::user('admin')->can('view projects.pending')) {
            abort(403);
        }

        $statuses = ProjectStatus::getPendingStatuess();  // get all enum cases

        if ($request->ajax()) {
            $projects = $this->projectService->getPendingProjectsQuery()->orderBy('id', 'desc');

            if ($request->status) {
                $projects->where('status', $request->status);
            }
            return DataTables::of($projects)
                ->addColumn('customer_name', fn($row) => $row->customer?->full_name)
                ->addColumn('reference_number', fn($row) => $row->reference_number ?? '')
                ->addColumn('project_type', fn($row) => $row->projectType?->name)
                ->addColumn('category', fn($row) => $row->category?->name)
                ->addColumn('region', fn($row) => $row->region?->name)
                ->addColumn('status', fn($row) => \App\Enums\ProjectStatus::getLabel($row->status))
                ->addColumn('action', function ($row) {
                    if (auth()->user()->can('view projects.pending')) {
                        return '<a href="' . route('admin.projects.pending.edit', $row->id) . '">
                                <i class="fa-regular fa-eye"></i>
                            </a>';
                    }
                    return '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.projects.pending.index', compact('statuses'));
    }

    public function activeProjects(Request $request)
    {
        $user = Auth::user('admin');

        if (!$user->can('view projects.active')) {
            abort(403);
        }

        $filters = [];

        if ($request->ajax()) {
            $projects = $this->projectService->getActiveProjectsQuery($filters)->orderBy('id', 'desc');
            if ($user->isConsultant()) {
                $projects = $projects->where('consultant_id', $user->consultant->id);
            }
            if ($request->status) {
                $projects->where('status', $request->status);
            }

            return DataTables::of($projects)
                ->addColumn('customer_name', fn($row) => $row->customer?->full_name)
                ->addColumn('reference_number', fn($row) => $row->reference_number ?? '')
                ->addColumn('project_type', fn($row) => $row->projectType?->name)
                ->addColumn('category', fn($row) => $row->category?->name)
                ->addColumn('region', fn($row) => $row->region?->name)
                ->addColumn('status', fn($row) => ProjectStatus::getLabel($row->status))
                ->addColumn('action', function ($row) use ($user) {
                    $actions = '';

                    if ($user->can('view projects.active')) {
                        $actions .= '<a href="' . route('admin.projects.active.edit', $row->id) . '">
                                    <i class="fa-regular fa-eye"></i>
                                </a>';
                    }

                    if ($row->status === ProjectStatus::IN_PROGRESS->value && $user->can('view projects.workstages')) {
                        $actions .= '<a href="' . route('admin.projects.active.workstages', $row->id) . '">
                                    <i class="fa-solid fa-diagram-project"></i>
                                </a>';
                    }

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $statuses = ProjectStatus::getActiveStatuess();  // pass all statuses to view
        return view('admin.projects.active.index', compact('statuses'));
    }

    public function completedProjects(Request $request)
    {
        $user = Auth::user('admin');

        if (!$user->can('view projects.completed')) {
            abort(403);
        }

        $filters = [];

        if ($request->ajax()) {
            $projects = $this->projectService->getCompletedProjectsQuery($filters)->orderBy('id', 'desc');

            if ($request->status) {
                $projects->where('status', $request->status);
            }

            return DataTables::of($projects)
                ->addColumn('customer_name', fn($row) => $row->customer?->full_name)
                ->addColumn('reference_number', fn($row) => $row->reference_number ?? '')
                ->addColumn('project_type', fn($row) => $row->projectType?->name)
                ->addColumn('category', fn($row) => $row->category?->name)
                ->addColumn('region', fn($row) => $row->region?->name)
                ->addColumn('status', fn($row) => ProjectStatus::getLabel($row->status))
                ->addColumn('action', function ($row) use ($user) {
                    $actions = '';

                    if ($row->status === ProjectStatus::COMPLETED->value && $user->can('view projects.completed')) {
                        $actions .= '<a href="' . route('admin.projects.completed.show', $row->id) . '">
                                    <i class="fa-solid fa-diagram-project"></i></a>';
                    }

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $statuses = ProjectStatus::getActiveStatuess();  // pass all statuses to view
        return view('admin.projects.completed.index', compact('statuses'));
    }

    // public function completedProjects()
    // {
    //     if (!Auth::user('admin')->can('view projects.completed'))
    //         abort(403);
    //     $projects = $this->projectService->getCompletedProjects();
    //     return view('admin.projects.completed.index', compact('projects'));
    // }

    public function editActiveProject($id)
    {
        $project = $this->projectService->getProjectById($id);

        if (!Auth::user('admin')->canany(['view projects.pending', 'view projects.active']))
            abort(403);

        $data['project'] = $project;
        $attachments = [];
        foreach (config('project.files') as $type) {
            $attachments[$type['label']] = $project->attachments()->where('file_name', $type['name'])->get();
        }

        $data['attachments'] = $attachments;
        $data['consultants'] = Consultant::where('specialty_id', $project->service_type)->get();
        if ($project->status == ProjectStatus::OPEN_FOR_OFFERS->value) {
            $data['providers'] = Provider::where('status', 'active')
                ->orderBy('company_name')
                ->get();
            $data['selectedProviderIds'] = $project->scopedProviders()->pluck('providers.id')->toArray();
        }

        return view('admin.projects.active.edit', $data);
    }
    public function editPendingProject($id)
    {
        $project = $this->projectService->getProjectById($id);

        if (!Auth::user('admin')->canany(['view projects.pending', 'view projects.active']))
            abort(403);

        $data['project'] = $project;
        $attachments = [];
        foreach (config('project.files') as $type) {
            $attachments[$type['label']] = $project->attachments()->where('file_name', $type['name'])->get();
        }

        $data['attachments'] = $attachments;
        $data['consultants'] = Consultant::where('specialty_id', $project->service_type)->get();
        if ($project->status == ProjectStatus::OPEN_FOR_OFFERS->value) {
            $data['providers'] = Provider::where('status', 'active')
                ->orderBy('company_name')
                ->get();
            $data['selectedProviderIds'] = $project->scopedProviders()->pluck('providers.id')->toArray();
        }

        return view('admin.projects.pending.edit', $data);
    }

    public function updateStatus($id, Request $request)
    {
        if (!Auth::user('admin')->can('edit projects.pending'))
            abort(403);
        $request->validate([
            'status' => 'required|in:require_complete,accepted,open_for_offers,in_progress,completed,rejected,pending',
            'msg' => 'nullable|string',
        ]);

        $project = $this->projectService->updateProjectStatus($id, $request->status, $request->msg);

        return redirect()->back()->with('success', 'تم تحديث حالة المشروع بنجاح');
    }

    public function updateProviderScope($id, Request $request)
    {
        if (!Auth::user('admin')->canany(['edit projects.pending', 'edit projects.active'])) {
            abort(403);
        }

        $project = $this->projectService->getProjectById($id);
        if (!$project || $project->status !== ProjectStatus::OPEN_FOR_OFFERS->value) {
            return redirect()->back()->withErrors(['providers' => 'يمكن تعديل نطاق المقاولين فقط عندما تكون حالة المشروع متاح للعروض.']);
        }

        $validated = $request->validate([
            'provider_ids' => 'nullable|array',
            'provider_ids.*' => 'exists:providers,id',
        ]);

        $providerIds = $validated['provider_ids'] ?? [];
        $project->scopedProviders()->sync($providerIds);

        return redirect()->back()->with('success', 'تم تحديث نطاق المقاولين بنجاح');
    }

    public function updateConsultant($id, Request $request)
    {
        if (!Auth::user('admin')->canany(['edit projects.pending', 'edit projects.active'])) {
            abort(403);
        }

        $project = $this->projectService->getProjectById($id);
        if (!$project) {
            abort(404);
        }

        $validated = $request->validate([
            'consultant_id' => 'required|exists:consultants,id',
        ]);

        $consultant = Consultant::where('id', $validated['consultant_id'])
            ->where('specialty_id', $project->service_type)
            ->first();

        if (!$consultant) {
            return redirect()->back()->withErrors(['consultant_id' => 'الاستشاري غير متوافق مع تخصص المشروع.']);
        }

        $project->consultant_id = $consultant->id;
        $project->save();

        return redirect()->back()->with('success', 'تم تحديث الاستشاري بنجاح');
    }

    public function showWorkStages($id)
    {
        $user = Auth::user('admin');

        if (!$user->can('view projects.workstages'))
            abort(403);

        $project = $this->projectService->getProjectById($id);

        if ($user->isConsultant() && $project->consultant_id != $user->consultant->id)
            abort(403);

        if ($project->status == ProjectStatus::COMPLETED->value) {
            return redirect()->route('admin.projects.completed.show', $project->id);
        }

        if ($project->status != ProjectStatus::IN_PROGRESS->value)
            abort(404);

        $offer = $project->acceptedOffer();
        $details = OfferUtility::getDetails($offer);
        return view('admin.projects.active.work-stages', compact('project', 'offer', 'details'));
    }

    public function showCompletedProject($id)
    {
        if (!Auth::user('admin')->can('view projects.completed'))
            abort(403);
        $project = $this->projectService->getProjectById($id);

        if ($project->status != ProjectStatus::COMPLETED->value)
            abort(404);

        $offer = $project->completedOffer();
        $details = OfferUtility::getDetails($offer);
        return view('admin.projects.completed.show', compact('project', 'offer', 'details'));
    }

    public function previewFile($id)
    {
        $file = ProjectAttachment::findOrFail($id);

        if (!Storage::disk('private_files')->exists($file->file_path)) {
            abort(404);
        }

        return response()->file($this->attachmentAbsolutePath($file));
    }

    public function downloadFile($id)
    {
        $file = ProjectAttachment::findOrFail($id);

        if (!Storage::disk('private_files')->exists($file->file_path)) {
            abort(404);
        }

        return response()->download(
            $this->attachmentAbsolutePath($file),
            $this->attachmentDownloadName($file)
        );
    }

    private function attachmentAbsolutePath(ProjectAttachment $file): string
    {
        return storage_path('app/private_files/' . ltrim($file->file_path, '/'));
    }

    private function attachmentDownloadName(ProjectAttachment $file): string
    {
        $attachmentConfig = collect(config('project.files'))->firstWhere('name', $file->file_name);
        $baseName = $attachmentConfig['label'] ?? $file->file_name;
        $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);

        return $extension ? $baseName . '.' . $extension : $baseName;
    }
}

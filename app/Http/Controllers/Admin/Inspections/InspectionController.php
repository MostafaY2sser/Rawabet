<?php

namespace App\Http\Controllers\Admin\Inspections;

use App\Enums\InspectionStatus;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InspectionController extends Controller
{
    protected $inspectionService;

    public function __construct(\App\Services\Admin\InspectionService $inspectionService)
    { 
        $this->inspectionService = $inspectionService;
    }

    public function index(Request $request)
    {
        $user = Auth::user('admin');
        if (!$user->can('view inspections')) {
            abort(403);
        }

        $filters = [
            'status' => $request->status,
            'search' => $request->search,
        ];

        // Build the base query depending on role
        $query = $user->isConsultant()
            ? $this->inspectionService->getAllInspectionsQueryByConsultant($user->consultant?->id)
            : $this->inspectionService->getAllInspectionsQuery();

            $query = $query->where("type" , "first_inspection");
        // Apply filters
        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }


        if ($request->ajax()) {
            // make sure getRequestsQuery() returns a query builder, not a collection

            return DataTables::of($query)
                ->addColumn('project_title', function ($row) {
                    return $row->project->serviceType?->name . ' ' . $row->project->buildingType?->name;
                })
                ->addColumn('reference_number', function ($row) {
                    return $row->project->reference_number;
                })
                ->addColumn('customer_name', function ($row) {
                    return $row->project->customer->full_name;
                })
                ->editColumn('date', function ($row) {
                    return \Carbon\Carbon::parse($row->date)->format('Y-m-d');
                })
                ->editColumn('time', function ($row) {
                    return \Carbon\Carbon::parse($row->time)->format('H:i');
                })
                ->addColumn('status', function ($row) {
                    return \App\Enums\InspectionStatus::getLabel($row->status);
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if ($row->status == \App\Enums\InspectionStatus::COMPLETED->value && auth()->user()->can('view inspections.reports')) {
                        $btn .= '<a href="' . route('admin.inspection.show.report', $row->id) . '"
                                            title="عرض تقرير المعاينة">
                                            <i class="fa-solid fa-file-lines"></i>
                                        </a>';
                    }
                    if ($row->status == \App\Enums\InspectionStatus::PENDING->value && auth()->user()->can('edit inspections')) {
                        $btn .= '  <a href="' . route('admin.inspection.edit', $row->id) . '" title="إضافة المعاينة">
                                            <i class="fa-solid fa-sliders"></i> <!-- Sliders/settings -->
                                        </a>';
                    }
                    if ($row->status == \App\Enums\InspectionStatus::PENDING->value && auth()->user()->can('create inspections.reports')) {
                        $btn .= '<a href="' . route('admin.inspection.create.report', $row->id) . '"
                                        title="إنشاء تقرير المعاينة">
                                        <i class="fa-solid fa-keyboard"></i> <!-- Represents data entry -->
                                    </a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $statuses = [];

        return view('admin.inspections.index', compact('statuses'));
    }

    public function assignInspector($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
            'consultant_id' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)  // validation errors
                ->withInput()  // old form input
                ->with('error', 'يرجى تصحيح الأخطاء في النموذج');  // custom flash message
        }
        $data = $request->only('date', 'time');
        $data['project_id'] = $id;
        $data['inspector_id'] = $request->input('consultant_id');

        $this->inspectionService->assignInspector($data);

        return redirect()->back()->with('success', 'Inspector assigned successfully.');
    }

    public function edit($id)
    {
        $user = Auth::user('admin');
        if (!$user->can('edit inspections')) {
            abort(403);
        }
        $inspection = $this->inspectionService->getInspectionById($id);

        $consultants = Consultant::where('specialty_id', $inspection->project->service_type)
            ->get();
        return view('admin.inspections.edit', compact('inspection', 'consultants'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user('admin');
        if (!$user->can('edit inspections')) {
            abort(403);
        }
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $data = [
            'date' => $request->date,
            'time' => $request->time,
            'inspection_id' => $id,
            'consultant_id' => $request->consultant_id
        ];

        $result = $this->inspectionService->update($data);

        if ($result)
            return redirect()->back()->with('success', 'Inspection updated successfully.');
    }

    public function createReport($id)
    {
        $user = Auth::user('admin');
        if (!$user->can('create inspections.reports')) {
            abort(403);
        }
         

        $inspection = $this->inspectionService->getInspectionById($id);

        if($inspection->status != InspectionStatus::PENDING->value)
        {
            return $this->showReport($id);

        }

        return view('admin.inspections.create-report', compact('inspection'));
    }

    public function StoreReport($id, Request $request)
    {
        $user = Auth::user('admin');
        if (!$user->can('create inspections.reports')) {
            abort(403);
        }
        $data = $request->validate([
            'summary' => 'required|string',
            'evaluation' => 'required|numeric|min:0|max:10',
            'properties' => 'required|array',
            'points' => 'required|array',
            'recommendations' => 'required|array',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpg,jpeg,png,pdf'
        ]);

        $data['inspection_id'] = $id;

        $this->inspectionService->createReport($data);

        return redirect()->route('admin.inspection.index')->with('success', 'تم إنشاء التقرير بنجاح.');
    }

    public function showReport($id)
    {
        $inspection = $this->inspectionService->getInspectionById($id);
        return view('admin.inspections.show-report', compact('inspection'));
    }
}

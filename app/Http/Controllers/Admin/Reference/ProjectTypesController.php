<?php

namespace App\Http\Controllers\Admin\Reference;

use App\Http\Controllers\Controller;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProjectTypesController extends Controller
{
     
    public function index(){
         $user = Auth::user('admin');

        if (!$user->can('view resources')) {
            abort(403);
        }

    if (request()->ajax()) {

        $query = ProjectType::query()->orderBy('id', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                return $row->status == 1
                    ? '<span class="badge bg-success text-light">نشط</span>'
                    : '<span class="badge bg-danger text-light">غير نشط</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if (auth('admin')->user()->can('edit resources')) {
                    $btn .= '<button class="btn btn-sm btn-outline-primary edit-region-btn"
                                data-id="' . $row->id . '"
                                data-name="' . e($row->name) . '"
                                data-description="' . e($row->description) . '"
                                data-status="' . $row->status . '"
                                data-route="' . route('admin.reference.project-types.update', $row->id) . '"
                                data-bs-toggle="modal"
                                data-bs-target="#editRegionModal"
                                type="button">
                                <i class="fa fa-edit"></i>
                              </button>';
                }
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }
        return view('admin.reference.project-types');
    }

    public function store(Request $request){
         $user = Auth::user('admin');

        if (!$user->can('create resources')) {
            abort(403);
        }
        $request->validate([
            "name"=>'required|unique:project_types,name',
            "description"=>'required',
            'status'=>'required'
        ]);

        ProjectType::create([
            "name"=>$request->name,
            "description"=>$request->description,
            "status"=>$request->status
        ]);

        return redirect()->back()->with('success' , 'created');
    }
    public function update(Request $request ,  $id){

         $user = Auth::user('admin');

        if (!$user->can('edit resources')) {
            abort(403);
        }
        $request->validate([
            "name"=>'required|unique:project_types,name,'.$id,
            "description"=>'required',
            'status'=>'required'
        ]);


        $ProjectType = ProjectType::find($id);
        $ProjectType->update([
            "name"=>$request->name,
            "description"=>$request->description,
            "status"=>$request->status
        ]);

        return redirect()->back()->with('success' , 'updated');
    }
}

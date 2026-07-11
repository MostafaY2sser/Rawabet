<?php

namespace App\Http\Controllers\Admin\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectCategory;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    
    public function index()
{
    $user = Auth::user('admin');

    if (!$user->can('view resources')) {
        abort(403);
    }

    if (request()->ajax()) {
        $specialities = ProjectCategory::orderBy('id', 'desc');

        return datatables()->of($specialities)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
 return $row->status == 1
                    ? '<span class="badge bg-success text-light">نشط</span>'
                    : '<span class="badge bg-danger text-light">غير نشط</span>';            })
            ->addColumn('action', function ($row) {
                $btn = '';
                if (auth('admin')->user()->can('edit resources')) {
                    $btn = '<button class="btn btn-sm btn-outline-primary edit-region-btn"
                        data-id="'.$row->id.'"
                        data-name="'.$row->name.'"
                        data-status="'.$row->status.'"
                        data-route="'.route('admin.reference.categories.update', $row->id).'"
                        data-bs-toggle="modal"
                        data-bs-target="#editRegionModal">
                        <i class="fa fa-edit"></i>
                    </button>';
                }
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    return view('admin.reference.categories');
}
    public function store(Request $request){
         $user = Auth::user('admin');

        if (!$user->can('create resources')) {
            abort(403);
        }
        $request->validate([
            "name"=>'required|unique:project_categories,name',
            'status'=>'required'
        ]);

        ProjectCategory::create([
            "name"=>$request->name,
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
            "name"=>'required|unique:project_categories,name,'.$id,
            'status'=>'required'
        ]);


        $ProjectCategory = ProjectCategory::find($id);
        $ProjectCategory->update([
            "name"=>$request->name,
            "status"=>$request->status
        ]);

        return redirect()->back()->with('success' , 'updated');
    }
}

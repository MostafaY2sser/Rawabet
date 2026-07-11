<?php

namespace App\Http\Controllers\Admin\Reference;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SpecialtyController extends Controller
{
    //

   public function index(Request $request)
    {
        $user = Auth::user('admin');
        if (!$user->can('view resources')) {
            abort(403);
        }

        // Handle AJAX for DataTable
        if ($request->ajax()) {
            $data = Speciality::select(['id', 'name', 'status'])->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
 return $row->status == 1
                    ? '<span class="badge bg-success text-light">نشط</span>'
                    : '<span class="badge bg-danger text-light">غير نشط</span>';                })
                ->addColumn('action', function ($row) use ($user) {
                    $btn = '';
                    if ($user->can('edit resources')) {
                        $btn .= '<button class="btn btn-sm btn-outline-primary edit-region-btn"
                                    data-id="'.$row->id.'"
                                    data-name="'.$row->name.'"
                                    data-status="'.$row->status.'"
                                    data-route="'.route('admin.reference.specialties.update', $row->id).'"
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

        return view('admin.reference.specialiies');
    }

    public function store(Request $request){
         $user = Auth::user('admin');

        if (!$user->can('create resources')) {
            abort(403);
        }
        $request->validate([
            "name"=>'required|unique:specialities,name',
            'status'=>'required'
        ]);

        Speciality::create([
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
            "name"=>'required|unique:specialities,name,'.$id,
            'status'=>'required'
        ]);


        $Speciality = Speciality::find($id);
        $Speciality->update([
            "name"=>$request->name,
            "status"=>$request->status
        ]);

        return redirect()->back()->with('success' , 'updated');
    }
}

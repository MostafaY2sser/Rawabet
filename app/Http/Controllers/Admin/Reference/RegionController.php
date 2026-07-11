<?php

namespace App\Http\Controllers\Admin\Reference;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RegionController extends Controller
{public function index(Request $request)
{
    $user = Auth::user('admin');

    if (!$user->can('view resources')) {
        abort(403);
    }

    if ($request->ajax()) {
        $regions = Region::query()->orderBy('id', 'desc');

        return DataTables::of($regions)
            ->addColumn('status', function($row){
                 return $row->status == 1
                    ? '<span class="badge bg-success text-light">نشط</span>'
                    : '<span class="badge bg-danger text-light">غير نشط</span>';
            })
            ->addColumn('cities', function ($row) {
                return '<a href="'.route('admin.reference.cities.index', ['region_id' => $row->id]).'" 
                            title="عرض المدن"><i class="fa-solid fa-location-dot"></i></a>';
            })
            ->addColumn('action', function ($row) use ($user) {
                $actions = '';
                if ($user->can('edit resources')) {
                    $actions .= '<button class="btn btn-sm btn-outline-primary edit-region-btn"
                                    data-id="'.$row->id.'" 
                                    data-name="'.$row->name.'" 
                                    data-status="'.$row->status.'" 
                                    data-route="'.route('admin.reference.regions.update', $row->id).'" 
                                    data-bs-toggle="modal" data-bs-target="#editRegionModal" type="button">
                                    <i class="fa fa-edit"></i>
                                </button>';
                }
                return $actions;
            })
            ->rawColumns(['cities','action' , 'status'])
            ->make(true);
    }

    return view('admin.reference.regions');
}

    public function store(Request $request){
         $user = Auth::user('admin');

        if (!$user->can('create resources')) {
            abort(403);
        }
        $request->validate([
            "name"=>'required|unique:regions,name',
            'status'=>'required'
        ]);

        Region::create([
            "name"=>$request->name,
            "status"=>$request->status
        ]);

        return redirect()->back()->with('success' , 'created');
    }
    public function update(Request $request , Region $region){

         $user = Auth::user('admin');

        if (!$user->can('edit resources')) {
            abort(403);
        }
        $request->validate([
            "name"=>'required|unique:regions,name,'.$region->id,
            'status'=>'required'
        ]);

        $region->update([
            "name"=>$request->name,
            "status"=>$request->status
        ]);

        return redirect()->back()->with('success' , 'updated');
    }
}

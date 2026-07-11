<?php

namespace App\Http\Controllers\Admin\Reference;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    //

  public function index()
{
    $user = Auth::user('admin');

    if (!$user->can('view resources')) {
        abort(403);
    }

    if (!request()->has('region_id')) {
        abort(404);
    }

    $regionId = request()->input('region_id');
    $region   = Region::findOrFail($regionId);

    // Ajax request for DataTables
    if (request()->ajax()) {
        $cities = City::where('region_id', $regionId)->orderBy('id', 'desc');

        return datatables()->of($cities)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
 return $row->status == 1
                    ? '<span class="badge bg-success text-light">نشط</span>'
                    : '<span class="badge bg-danger text-light">غير نشط</span>';
                            })
            ->addColumn('action', function ($row) {
                $editBtn = '';
                if (auth('admin')->user()->can('edit resources')) {
                    $editBtn = '<button class="btn btn-sm btn-outline-primary edit-region-btn"
                        data-id="'.$row->id.'"
                        data-name="'.$row->name.'"
                        data-status="'.$row->status.'"
                        data-route="'.route('admin.reference.cities.update', $row->id).'"
                        data-bs-toggle="modal"
                        data-bs-target="#editRegionModal">
                        <i class="fa fa-edit"></i>
                    </button>';
                }
                return $editBtn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    return view('admin.reference.cities', compact('region'));
}

     public function store(Request $request){
         $user = Auth::user('admin');

        if (!$user->can('create resources')) {
            abort(403);
        }
        $request->validate([
            "name"=>'required|unique:cities,name',
            'status'=>'required'
        ]);

        City::create([
            "name"=>$request->name,
            "status"=>$request->status,
            "region_id"=>$request->region_id
        ]);

        return redirect()->back()->with('success' , 'created');
    }
    public function update(Request $request , City $city){

         $user = Auth::user('admin');

        if (!$user->can('edit resources')) {
            abort(403);
        }
        $request->validate([
            "name"=>'required|unique:cities,name,'.$city->id,
            'status'=>'required'
        ]);

        $city->update([
            "name"=>$request->name,
            "status"=>$request->status
        ]);

        return redirect()->back()->with('success' , 'updated');
    }
}

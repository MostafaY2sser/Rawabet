<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
 public function getCitiesFromRegion(){
        $cityId = request()->input('region_id');
        if (!$cityId) {
            return response()->json(['error' => 'region ID is required'], 400);
        }

        $cities = \App\Models\City::where('region_id', $cityId)->where('status',1)->get();

        if ($cities->isEmpty()) {
            return response()->json(['message' => 'No cities found for this city'], 404);
        }

        return response()->json($cities, 200);

 }
 
 public function getCitiesFromRegions(Request $request)
{
    $regionIds = $request->input('region_ids', []);
    $cities = City::whereIn('region_id', $regionIds)->where('status',1)->get(['id', 'name']);
    return response()->json($cities);
}

}

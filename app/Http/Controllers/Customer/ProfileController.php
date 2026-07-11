<?php

namespace App\Http\Controllers\Customer;

use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Region;
use App\Services\Customer\AuthService;
use App\Services\Customer\PerojectService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

     public function index()
    {
        $customer = Auth::guard('customer')->user();
       

        $ratingQuery = $customer->ratingsQuery();

        // Get average rating in one query
        $averageRate = $ratingQuery->avg('customer_rating');

        $projectsQuery = Project::where('customer_id' , $customer->id);

        $myProjects = $projectsQuery->get();
        // Get latest 5 ratings
        $latestRatings = $customer->ratingsQuery()->latest()->take(5)->get();
        $monthsCount = Carbon::parse($customer->created_at)->diffInMonths(now());

        return view('customer.profile.index', compact('customer', 'myProjects', 'latestRatings', 'averageRate', 'monthsCount'));
    }
    public function compeleteAccount()
    {
        $customer = Auth::guard('customer')->user();
        $regions = Region::where('status' , 1)->get();
        return view('customer.profile.compelete', compact('customer', 'regions'));
    }

    public function compeleteAccountPost($id, Request $request)
    {
        $customer = Customer::findOrfail($id);
        $request->validate([
            'full_name' => 'required|string',
            'national_id' => 'required|numeric|unique:customers,national_id,' . $customer->id,
            'phone_number' => 'required',
            'email' => 'required|email|max:255|unique:customers,email,' . $customer->id,
            'personal_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'address' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'region_id' => 'required|integer',
            'payment_method' => 'nullable|integer',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $data = $request->except('_token', 'personal_image');

        $data['status'] = CustomerStatus::PENDING->value;
        if ($request->hasFile('personal_image')) {
            // Delete the old image if it exists
            if (!empty($customer->personal_image) && Storage::disk('public')->exists($customer->personal_image)) {
                Storage::disk('public')->delete($customer->personal_image);
            }

            // Store the new image
            $data['personal_image'] = $request->file('personal_image')->store('customers', 'public');
        }

        $result =  $this->authService->update($customer->id, $data);
        return view('customer.auth.successfull');
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $customer = Auth::guard('customer')->user();

        // ✅ Handle image upload
        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($customer->personal_image && Storage::disk('public')->exists($customer->personal_image)) {
                Storage::disk('public')->delete($customer->personal_image);
            }

            // store new image
            $path = $request->file('image')->store('customers', 'public');
            $customer->personal_image = $path;
        }

        // ✅ Update fields
        $customer->full_name = $request->full_name;
        $customer->phone_number = $request->phone_number;
        $customer->save();
        return redirect()->back()->with('success', 'تم تحديث الملف بنجاح ✅');
    }
}

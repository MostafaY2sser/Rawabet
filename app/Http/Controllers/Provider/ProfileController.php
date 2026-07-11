<?php

namespace App\Http\Controllers\Provider;

use App\Enums\OfferStatus;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Provider;
use App\Models\ProviderAttachment;
use App\Models\Region;
use App\Models\Speciality;
use App\Services\Provider\AuthService;
use App\Services\Provider\OfferService;
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
        $provider = Auth::guard('provider')->user();
        $attachments = [];
        foreach (config('provider.files') as $type) {
            $attachments[$type['label']] = $provider->attachments()->where('file_name', $type['name'])->get();
        }

        $ratingQuery = $provider->ratingsQuery();

        // Get average rating in one query
        $averageRate = $ratingQuery->avg('contractor_rating');

        $offerService = app()->make(OfferService::class);
        $offersQuery = $offerService->getAllOffersByProvider($provider->id);

        $myOffers = $offersQuery->where('status', OfferStatus::COMPLETED->value)->get();
        // Get latest 5 ratings
        $latestRatings = $provider->ratingsQuery()->latest()->take(5)->get();
        $monthsCount = Carbon::parse($provider->created_at)->diffInMonths(now());

        return view('provider.profile.index', compact('provider', 'myOffers', 'attachments', 'latestRatings', 'averageRate', 'monthsCount'));
    }

    public function addFile(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        $provider = Auth::guard('provider')->user();

        $file_path = $request->file->store('provider', 'private_files');

        $provider->attachments()->create([
            'file_path' => $file_path,
            'file_name' => 'extra_attachments'
        ]);
        return redirect()->back();
    }

    public function previewFile($id)
    {
        $file = $this->getOwnedAttachment($id);
        if (!Storage::disk('private_files')->exists($file->file_path)) {
            abort(404);
        }

        return response()->file($this->attachmentAbsolutePath($file));
    }

    public function downloadFile($id)
    {
        $file = $this->getOwnedAttachment($id);

        if (!Storage::disk('private_files')->exists($file->file_path)) {
            abort(404);
        }

        return response()->download($this->attachmentAbsolutePath($file), $this->attachmentDownloadName($file));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $provider = Auth::guard('provider')->user();

        // ✅ Handle image upload
        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($provider->image && Storage::disk('public')->exists($provider->image)) {
                Storage::disk('public')->delete($provider->image);
            }

            // store new image
            $path = $request->file('image')->store('provider/image', 'public');
            $provider->image = $path;
        }

        // ✅ Update fields
        $provider->company_name = $request->company_name;
        $provider->phone_number = $request->phone_number;
        $provider->save();
        return redirect()->back()->with('success', 'تم تحديث الملف بنجاح ✅');
    }

    public function compeleteAccount()
    {
        $provider = Auth::guard('provider')->user();
        $cities = City::where('status', 1)->get();
        $regions = Region::where('status', 1)->get();
        $specializations = Speciality::where('status', 1)->get();

        $selectedSpecializations = $provider->specializations()->pluck('specialization_id');
        $selectedCityIds = $provider->workCities()->pluck('city_id')->toArray();
        $selectedRegionIds = $provider->workRegions()->pluck('region_id')->toArray();
        $attachments = [];
        foreach (config('provider.files') as $type) {
            if ($type['name'] == 'extra_attachments')
                continue;
            $attachments[$type['label']] = ['files' => $provider->attachments()->where('file_name', $type['name'])->get(), 'optional' => $type['optional'], 'multiple' => $type['multiple'], 'name' => $type['name']];
        }
        return view('provider.profile.compelete', compact('provider', 'cities', 'regions', 'specializations', 'selectedSpecializations', 'selectedCityIds', 'selectedRegionIds', 'attachments'));
    }

    public function deleteFile(Request $request)
    {
        $file = ProviderAttachment::find($request->file_id);
        $file->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function compeleteAccountPost($id, Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'owner_id' => 'required|numeric|unique:providers,owner_id,' . $id,
            'commercial_registration' => 'required|numeric|unique:providers,commercial_registration,' . $id,
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:providers,email,' . $id,
            'address' => 'required|string',
            'region_id' => 'required|integer',
            'city_id' => 'required|integer',
            'specializations' => 'required|array',
            'specializations.*' => 'required|integer',
            'work_city_id' => 'required|array',
            'work_city_id.*' => 'required|integer',
            'work_region_id' => 'required|array',
            'work_region_id.*' => 'required|integer',
        ]);

        $provider = Provider::find($id);

        $result = $this->authService->updateAccount($request, $provider);

        return view('provider.auth.successfull');
    }

    private function getOwnedAttachment($id)
    {
        $provider = Auth::guard('provider')->user();

        return $provider->attachments()->findOrFail($id);
    }

    private function attachmentDownloadName(ProviderAttachment $file)
    {
        $attachmentConfig = collect(config('provider.files'))->firstWhere('name', $file->file_name);
        $baseName = $attachmentConfig['label'] ?? $file->file_name;
        $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);

        return $extension ? $baseName . '.' . $extension : $baseName;
    }

    private function attachmentAbsolutePath(ProviderAttachment $file)
    {
        return storage_path('app/private_files/' . ltrim($file->file_path, '/'));
    }
}

<?php

namespace App\Http\Controllers\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Provider;
use App\Models\Region;
use App\Models\Speciality;
use App\Services\Provider\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function stepOne()
    {
        $regions = Region::where('status',1)->get();
        return view('provider.auth.register.step_one', compact('regions'));
    }

    public function stepTwo($id)
    {
        return view('provider.auth.register.step_two', compact('id'));
    }

    public function stepThree($id)
    {
        $regions = Region::where('status',1)->get();
        $specializations = Speciality::where('status',1)->get();

        return view('provider.auth.register.step_three', compact('id', 'regions', 'specializations'));
    }

    public function registerStepOne(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'owner_id' => 'required|numeric|unique:providers',
            'commercial_registration' => 'required|numeric|unique:providers',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:providers',
            'address' => 'required|string',
            'region_id' => 'required|integer',
            'city_id' => 'required|integer',
            'password' => 'required|string|min:8',
        ]);
        $data = $request->except('confirm_password', 'agree_terms');
        $result = $this->authService->registerStepOne($data);
        if ($result) {
            return redirect()->route('provider.register.stepTwo', $result->id);
        }
        return back()->withErrors(['error' => 'Registration failed']);
    }

    public function registerStepTwo($id, Request $request)
    {
        $data = [];
        $attachmentsToInsert = [];

        foreach (config('provider.files') as $attachmentType) {
            $fieldName = $attachmentType['name'];
            $arabicLabel = $attachmentType['label'] ?? $fieldName;
            $isMultiple = $attachmentType['multiple'] ?? false;
            $isOptional = $attachmentType['optional'] ?? false;
            $required = $isOptional ? 'nullable' : 'required';
            $extensions = $attachmentType['extensions'] ?? [];

            $mimesRule = 'mimes:' . implode(',', $extensions);
            $rules = [];
            $messages = [];

            if ($isMultiple) {
                $rules[$fieldName] = "$required|array";
                $rules["$fieldName.*"] = "$required|$mimesRule";

                if (!empty($attachmentType['min'])) {
                    $rules[$fieldName] .= '|min:' . $attachmentType['min'];
                    $messages["$fieldName.min"] = "يجب رفع على الأقل {$attachmentType['min']} من $arabicLabel.";
                }

                $messages["$fieldName.required"] = "حقل $arabicLabel مطلوب.";
                $messages["$fieldName.*.mimes"] = "$arabicLabel يجب أن يكون من الأنواع التالية: " . implode(', ', $extensions);
            } else {
                $rules[$fieldName] = "$required|$mimesRule";
                $messages["$fieldName.required"] = "حقل $arabicLabel مطلوب.";
                $messages["$fieldName.mimes"] = "$arabicLabel يجب أن يكون من الأنواع التالية: " . implode(', ', $extensions);
            }

            $request->validate($rules, $messages);

            $files = $isMultiple ? $request->file($fieldName) : [$request->file($fieldName)];
            foreach ($files as $file) {
                if ($file) {
                    $path = $file->store('provider', 'private_files');

                    $attachmentsToInsert[] = [
                        'file_path' => $path,
                        'file_name' => $fieldName,
                    ];
                }
            }
        }

        $result = $this->authService->registerStepTwo($id, $attachmentsToInsert);

        if ($result) {
            return redirect()->route('provider.register.stepThree', $result->id);
        }
        return back()->withErrors(['error' => 'Registration failed']);
    }

    public function registerStepThree(Request $request, $id)
    {
        $request->validate([
            'specializations' => 'required|array',
            'specializations.*' => 'required|integer',
            'city_id' => 'required|array',
            'city_id.*' => 'required|integer',
            'region_id' => 'required|array',
            'region_id.*' => 'required|integer',
        ]);

        $data = $request->all();
        $data['user_id'] = $id;

        // Update the provider with step three data
        $result = $this->authService->registerStepThree($data);
        if ($result) {
            return redirect()->route('provider.login')->with('success', 'تم تسجيل الحساب بنجاح');
        }
        return back()->withErrors(['error' => 'Registration failed']);
    }
}

<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use App\Services\Customer\Interfaces\AuthServiceInterface;
use App\Services\Customer\AuthService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function stepOne()
    {
        return view('customer.auth.register.step_one');
    }

    public function stepTwo($id)
    {
        return view('customer.auth.register.step_two', compact('id'));
    }

    public function stepThree($id)
    {
        $regions = Region::where('status', 1)->get();
        return view('customer.auth.register.step_three', compact('id', 'regions'));
    }

    public function registerStepOne(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'national_id' => 'required|numeric|unique:customers',
            'phone_number' => 'required',
            'email' => 'required|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required_with:password|same:password|min:8',
        ], [
            'full_name.required' => 'الاسم الكامل مطلوب.',
            'full_name.string' => 'الاسم الكامل يجب أن يكون نصًا.',
            'national_id.required' => 'رقم الهوية مطلوب.',
            'national_id.numeric' => 'رقم الهوية يجب أن يكون رقمًا.',
            'national_id.unique' => 'رقم الهوية مستخدم بالفعل.',
            'phone_number.required' => 'رقم الهاتف مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.max' => 'البريد الإلكتروني لا يجب أن يزيد عن 255 حرفًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'confirm_password.required_with' => 'تأكيد كلمة المرور مطلوب عند إدخال كلمة المرور.',
            'confirm_password.same' => 'تأكيد كلمة المرور غير مطابق لكلمة المرور.',
            'confirm_password.min' => 'تأكيد كلمة المرور يجب أن يكون 8 أحرف على الأقل.',
        ]);

        $data = $request->except('confirm_password', 'agree_terms');
        $result = $this->authService->registerStepOne($data);
        $data['account_verfication'] = 1;
        $data['user_id'] = $result->id;
        $result = $this->authService->registerStepTwo($data);
        if ($result) {
            return redirect()->route('customer.register.stepThree', $result->id);
        }
        return back()->withErrors(['error' => 'Registration failed']);
    }

    public function registerStepTwo($id)
    {
        $data['account_verfication'] = 1;
        $data['user_id'] = $id;
        $result = $this->authService->registerStepTwo($data);
        if ($result) {
            return redirect()->route('customer.register.stepThree', $result->id);
        }
        return back()->withErrors(['error' => 'Registration failed']);
    }

    public function registerStepThree(Request $request, $id)
    {
        $request->validate([
            'personal_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'address' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'region_id' => 'required|integer',
            'payment_method' => 'nullable|integer',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        $data = $request->all();
        $data['user_id'] = $id;
        // Handle file upload for personal_image if exists
        if ($request->hasFile('personal_image')) {
            $data['personal_image'] = $request->file('personal_image')->store('customers', 'public');
        }

        // Update the customer with step three data
        $result = $this->authService->registerStepThree($data);
        if ($result) {
            return redirect()->route('customer.login')->with('success', 'Registration completed successfully');
        }
        return back()->withErrors(['error' => 'Registration failed']);
    }
}

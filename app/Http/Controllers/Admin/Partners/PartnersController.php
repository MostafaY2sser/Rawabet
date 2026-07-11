<?php

namespace App\Http\Controllers\Admin\Partners;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PartnersController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user('admin');

        if (!$user->can('view partners')) {
            abort(403);
        }

        $partners = Partner::all();
        return view('admin.partners.partners', compact('partners'));
    }

    public function store(Request $request)
    {
        $user = Auth::user('admin');

        if (!$user->can('create partners')) {
            abort(403);
        }
        $request->validate([
            'email' => [
                'required',
                'email',
                'email' => ['required', 'email', 'unique:partners,email'],
                'unique:partners,email',  // ✅ email must be unique in `users` table
            ],
            'phone_number' => [
                'required',
                'numeric',
                'unique:partners,phone_number',  // ✅ phone must be unique
            ],
            'name' => [
                'required',
                'unique:partners,name',  // ✅ name must be unique
            ],
            'logo' => [
                'required',
                'image',
            ],
        ], [
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
            'email.regex' => 'يجب أن يكون البريد الإلكتروني من النطاق domain.com.',
            'phone_number.unique' => 'رقم الهاتف مستخدم بالفعل.',
            'name.unique' => 'الاسم مستخدم بالفعل.',
            'phone_number.numeric' => 'رقم الهاتف يجب أن يحتوي على أرقام فقط.',
            'logo.image' => 'يجب أن يكون الشعار صورة صالحة.',
        ]);

        $path = $request->file('logo')->store('partners', 'public');
        Partner::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'logo' => $path
            ]
        );

        return redirect()->back()->with('success', 'created');
    }

    public function update(Request $request, Partner $partner)
    {
        $user = Auth::user('admin');

        if (!$user->can('edit partners')) {
            abort(403);
        }
        $request->validate([
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'name' => 'required',
            'logo' => 'nullable|image'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ];
        if ($request->hasFile('logo')) {
            if (Storage::disk('public')->exists($partner->logo)) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }
        $partner->update($data);

        return redirect()->back()->with('success', 'updated');
    }
}

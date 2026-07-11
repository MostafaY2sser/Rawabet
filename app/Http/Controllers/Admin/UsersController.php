<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Consultant;
use App\Models\Speciality;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        if(!Auth::user('admin')->can('view users'))
        abort(403);
        $users = $this->userService->getAllUsers();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if(!Auth::user('admin')->can('create users'))
        abort(403);
        $roles = Role::all();

        $specailites = Speciality::where('status' , 1)->get();
        return view('admin.users.create', compact('roles', 'specailites'));
    }

    public function store(Request $request)
    {

            if(!Auth::user('admin')->can('create users'))
        abort(403);
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|min:6',
            'role_id' => 'required|exists:roles,id',
            // Only required if consultant role is selected
            'specialty_id' => 'required_if:role_id,1',
            'phone_number' => 'required_if:role_id,1|string|max:20',
            'identity_number' => 'required_if:role_id,1|string|max:50',
            'experience_years' => 'required_if:role_id,1|numeric|min:0',
            'certificates' => 'required_if:role_id,1|string',
            'avatar' => 'nullable|image',  // Max 2MB
        ]);

        $this->userService->store($request);

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء الحساب بنجاح');
    }

    public function edit($id)
    {
         if(!Auth::user('admin')->can('edit users'))
        abort(403);
        $user = Admin::findorFail($id);
        $roles = Role::all();
        $specailites = Speciality::where('status' , 1)->get();
        
        return view('admin.users.edit', compact('user', 'roles', 'specailites'));
    }


    public function update(Request $request , $id)
    {
           if(!Auth::user('admin')->can('edit users'))
        abort(403);
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|confirmed|min:6',
            'role_id' => 'required|exists:roles,id',
            // Only required if consultant role is selected
            'specialty_id' => 'required_if:role_id,1',
            'phone_number' => 'required_if:role_id,1|string|max:20',
            'identity_number' => 'required_if:role_id,1|string|max:50',
            'experience_years' => 'required_if:role_id,1|numeric|min:0',
            'certificates' => 'required_if:role_id,1|string',
            'avatar' => 'nullable|image',  // Max 2MB
        ]);

        $this->userService->update($request, $id);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث الحساب بنجاح');
    }
}

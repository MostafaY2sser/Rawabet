<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
       
        if (!Auth::user('admin')->can('view roles'))
            abort(403);
        $roles = $this->roleService->getAllRoles();
        return view('admin.roles.index', compact('roles'));
    }

    public function edit($id)
    {
        if (!Auth::user('admin')->can('edit roles'))
            abort(403);
        $role = $this->roleService->getRoleWihPermissions($id);

        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode(' ', $perm->name)[1];  // e.g., 'customers', 'projects'
        });

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user('admin')->can('edit roles'))
            abort(403);
        $request->validate([
            'name' => 'required',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $data = $request->except('_token');
        $data['role_id'] = $id;

        $result = $this->roleService->update($data);
        if ($result)
            return redirect()->back()->with('success', 'تم تحديث الدور بنجاح ✅');
    }
}

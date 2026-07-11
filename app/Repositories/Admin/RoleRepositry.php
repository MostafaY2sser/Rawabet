<?php
namespace App\Repositories\Admin;

use Spatie\Permission\Models\Role;

class RoleRepositry
{
    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRoleWihPermissions($id)
    {
        return Role::with('permissions')->find($id);
    }

    public function update($data)
    {
        $role = Role::findById($data['role_id']);

        $role->name = $data['name'];
        $role->syncPermissions($data['permissions']);

        return $role;
    }
}

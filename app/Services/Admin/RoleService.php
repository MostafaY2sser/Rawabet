<?php
namespace App\Services\Admin;

use App\Repositories\Admin\RoleRepositry;
use App\Repositories\Admin\UserRepositry;

class RoleService
{
  protected $roleRepositry;

  public function __construct(RoleRepositry $RoleRepositry)
  {
    $this->roleRepositry = $RoleRepositry;
  }

  public function getAllRoles()
  {
    return $this->roleRepositry->getAllRoles();
  }

  public function getRoleWihPermissions($id)
  {
    return $this->roleRepositry->getRoleWihPermissions($id);
  }

  public function update($data)
  {
    return $this->roleRepositry->update($data);
  }
}

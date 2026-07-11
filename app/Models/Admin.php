<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;
    use HasFactory;

    public $guarded =['id'];
    public function isSuperAdmin(): bool
{
    return $this->type === 'super_admin'; // or return $this->is_super_admin === true;
}
    public function isConsultant(): bool
{
    return $this->role()?->id == 1; // or return $this->is_super_admin === true;
}

public function role(){
    return $this->roles->first();
}

public function consultant(){
    return $this->hasOne(Consultant::class , 'account_id');
}

public function notifications()
    {
        return $this->morphMany(Notification::class, 'resever', 'resever_type', 'resever_id');
    }
}

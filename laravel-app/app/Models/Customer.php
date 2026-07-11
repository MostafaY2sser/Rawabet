<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'national_id',
        'phone_number',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderWorkCity extends Model
{
    use HasFactory;
    public $guarded = ['id'];
    public $table = 'provider_work_cities';
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory;

    public $guarded =['id'];

    public function spciality(){
        return $this->belongsTo(Speciality::class , 'specialty_id');
    }
    public function projects(){
        return $this->hasMany(Project::class , 'consultant_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAttachment extends Model
{
    use HasFactory;
    public $table ='project_attahcments';
    public $guarded = ['id'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}

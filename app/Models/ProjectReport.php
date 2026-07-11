<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectReport extends Model
{
    use HasFactory;

    public $table = 'project_reports';

    public $guarded = ['id'];

    public function attachments(){
        return $this->hasMany(ProjectReportAttachment::class , 'report_id');
    }
    public function author(){
        return $this->belongsTo(Admin::class , 'added_by');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }
}

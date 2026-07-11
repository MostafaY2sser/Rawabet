<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectReportAttachment extends Model
{
    use HasFactory;
       public $table = 'project_reports_attachments';

    public $guarded = ['id'];
}

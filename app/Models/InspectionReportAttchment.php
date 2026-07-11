<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionReportAttchment extends Model
{

    public $table = 'inspection_reports_attachments';
    use HasFactory;
    public $guarded =['id'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionReport extends Model
{
    use HasFactory;
    public $table = 'inspection_reports';
    public $guarded =['id'];
 
    public function attachments(){
        return $this->hasMany(InspectionReportAttchment::class,'report_id');
    }
}

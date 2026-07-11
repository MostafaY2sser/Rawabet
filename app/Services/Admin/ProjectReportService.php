<?php 
namespace App\Services\Admin;

use App\Repositories\Admin\ProjecReportRepositry;
use Illuminate\Support\Facades\Auth;

class ProjectReportService{


    protected $reportRepo;
    public function __construct(ProjecReportRepositry $reportRepo)
    {

        $this->reportRepo = $reportRepo;

    }
    public function store($data , $attachments)
    {
        $data['added_by'] = Auth::guard('admin')->user()->id;


        return $this->reportRepo->store($data, $attachments);
        
        

    }


}
<?php
namespace App\Repositories\Admin;

use App\Models\ProjectReport;

class ProjecReportRepositry{

    public function store($data , $attachments){

        $report =  ProjectReport::create($data);

        if(!empty($attachment)){
          foreach ($attachments as $attachment) {
            $path = $attachment->store('project_reports', 'public');
            $report->attachments()->create([
                'file_path' => $path,
                "file_name"=>$attachment->getClientOriginalName(),
                
            ]);

        }}

        return $report; 
    }

}
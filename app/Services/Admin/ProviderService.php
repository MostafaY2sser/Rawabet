<?php

namespace App\Services\Admin;

use App\Models\Provider;
use App\Repositories\Admin\ProviderRepository;

class ProviderService 
{
    protected $ProviderRepo;

    public function __construct(ProviderRepository $ProviderRepo)
    {
        $this->ProviderRepo = $ProviderRepo;
    }

    public function getRequests(){
        return $this->ProviderRepo->getRequests();
    }
    public function getRequestsQuery(){
        return $this->ProviderRepo->getRequestsQuery();
    }
    public function getActiveProviders(){
        return $this->ProviderRepo->getActiveProviders();
    }
    public function getActiveProvidersQuery(){
        return $this->ProviderRepo->getActiveProvidersQuery();
    }

    public function updateStatus($id , $status , $comment){
       $Provider = Provider::find($id);

       return $this->ProviderRepo->updateStatus($Provider , ['status'=>$status , 'admin_comment'=>$comment]);
    }

   
}

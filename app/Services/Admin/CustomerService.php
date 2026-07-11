<?php

namespace App\Services\Admin;

use App\Models\Customer;
use App\Repositories\Admin\CustomerRepository;

class CustomerService 
{
    protected $customerRepo;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function getRequests(){
        return $this->customerRepo->getRequests();
    }
    public function getRequestsQuery(){
        return $this->customerRepo->getRequestsQuery();
    }
    public function getActiveCustomers($search = null){
        return $this->customerRepo->getActiveCustomers($search);
    }
    public function getActiveCustomersQuery($search = null){
        return $this->customerRepo->getActiveCustomersQuery();
    }

    public function updateStatus($id , $status,$comment){
       $customer = Customer::find($id);

       return $this->customerRepo->updateStatus($customer , ['status'=>$status, 'admin_comment'=>$comment]);
    }

   
}

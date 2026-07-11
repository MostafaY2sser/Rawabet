<?php

namespace App\Repositories\Admin;

use App\Enums\CustomerStatus;
use App\Models\Customer;

class CustomerRepository
{
    public function getRequests()
    {
        return Customer::Where('status', '<>', CustomerStatus::ACTIVE->value)->paginate(10);
    }
    public function getRequestsQuery()
    {
        return Customer::Where('status', '<>', CustomerStatus::ACTIVE->value);
    }


    public function getActiveCustomers($search = null)
    {
            $query = Customer::where('status', 'active');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone_number', 'LIKE', "%{$search}%");
                });
            }

            return $query->get();
        

    }

    public function getActiveCustomersQuery()
    {
            $query = Customer::where('status', 'active');
            

        

    }

    public function updateStatus(Customer $customer, $data)
    {
        $customer->update($data);
        return $customer;
    }
}

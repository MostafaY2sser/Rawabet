<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\Customer\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function createStepOne(array $data)
    {
        return Customer::create($data);  // Only basic fields at step one
    }

    public function updateStepTwo(int $CustomerId, array $data)
    {
        $Customer = Customer::findOrFail($CustomerId);
        unset($data['user_id']);  // Remove user_id if it exists in the data
        $Customer->update($data);
        return $Customer;
    }

    public function updateStepThree(int $CustomerId, array $data)
    {
        $Customer = Customer::findOrFail($CustomerId);
        unset($data['user_id']);  // Remove user_id if it exists in the data
        $Customer->update($data);
        return $Customer;
    }

    public function findByEmail(string $email)
    {
        return Customer::where('email', $email)->first();
    }

    public function update($id, $data)
    {
        $Customer = Customer::find($id);
        $Customer->update($data);
        return $Customer;
    }

  
}

<?php

namespace App\Services\Customer;

use App\Services\Customer\Interfaces\AuthServiceInterface;
use App\Repositories\Customer\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function registerStepOne(array $data)
    {    
       
       
        return $this->authRepo->createStepOne($data);
    }

    public function registerStepTwo(array $data)
    {
        $data['step'] = 2;
        return $this->authRepo->updateStepTwo($data['user_id'], $data);
    }
    public function registerStepThree(array $data)
    {
        $data['step'] = 3;
        return $this->authRepo->updateStepThree($data['user_id'], $data);
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        return Auth::user();
    }

    public function update($id, $data){
        return $this->authRepo->update($id , $data);
    }
}

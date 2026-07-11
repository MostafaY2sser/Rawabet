<?php

namespace App\Services\Provider;

use App\Models\Provider;
use App\Services\Provider\Interfaces\AuthServiceInterface;
use App\Repositories\Provider\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
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

    public function registerStepTwo($id,array $data)
    {
        
        return $this->authRepo->updateStepTwo($id, $data);
    }
    public function registerStepThree(array $data)
    {
        return $this->authRepo->updateStepThree($data['user_id'], $data);
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        return Auth::user();
    }

    public function updateAccount(Request $request , Provider $provider){
        return $this->authRepo->updateProviderAccount($request , $provider);
    }
}

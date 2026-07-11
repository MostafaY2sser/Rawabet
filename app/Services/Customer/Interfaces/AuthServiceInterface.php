<?php

namespace App\Services\Customer\Interfaces;

interface AuthServiceInterface
{
    public function registerStepOne(array $data);
    public function registerStepTwo(array $data);
    public function registerStepThree(array $data);
    public function login(array $credentials);
}

<?php

namespace App\Services\Provider\Interfaces;

interface AuthServiceInterface
{
    public function registerStepOne(array $data);
    public function registerStepTwo($id,array $data);
    public function registerStepThree(array $data);
    public function login(array $credentials);
}

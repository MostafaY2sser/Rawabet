<?php

namespace App\Repositories\Customer\Interfaces;

interface AuthRepositoryInterface
{
    public function createStepOne(array $data);
    public function updateStepTwo(int $userId, array $data);
    public function updateStepThree(int $userId, array $data);

    public function update(int $userId, array $data);

    public function findByEmail(string $email);
}

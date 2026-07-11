<?php

namespace App\Repositories\Provider\Interfaces;

use App\Models\Provider;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function createStepOne(array $data);
    public function prepareAttachmentForUpdate(Request $request , Provider $provider);
    public function updateProviderAccount(Request $request , Provider $provider);
    public function uploadProviderAttachments($data , Provider $provider);
    public function updateStepTwo(int $userId, array $data);
    public function updateStepThree(int $userId, array $data);

    public function findByEmail(string $email);
}

<?php

namespace App\Repositories\Admin;

use App\Enums\CustomerStatus;
use App\Enums\ProviderStatus;
use App\Models\Customer;
use App\Models\Provider;

class ProviderRepository
{
    public function getRequests()
    {
        return Provider::Where('status', '<>', ProviderStatus::ACTIVE->value)->paginate(10);
    }
    public function getRequestsQuery()
    {
        return Provider::Where('status', '<>', ProviderStatus::ACTIVE->value);
    }
    public function getActiveProviders()
    {
               return Provider::Where('status', ProviderStatus::ACTIVE->value)->paginate(10);

    }
    public function getActiveProvidersQuery()
    {
               return Provider::Where('status', ProviderStatus::ACTIVE->value);

    }


    public function updateStatus(Provider $Provider, $data)
    {
        $Provider->update($data);
        return $Provider;
    }

}

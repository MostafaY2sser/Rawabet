<?php

namespace App\Services\Customer;

use App\Repositories\Customer\ContractRepository;

class ContractService
{
    protected $contractRepo;

    public function __construct(ContractRepository $contractRepo)
    {
        $this->contractRepo = $contractRepo;
    }

    public function create(array $data)
    {
        return $this->contractRepo->store($data);
    }
     public function update(array $data){

        return $this->contractRepo->update($data);

    }
}

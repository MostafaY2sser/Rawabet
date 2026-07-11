<?php
namespace App\Repositories\Customer;

use App\Models\Contract;

class ContractRepository
{
    public function store($data)
    {
        $contract = Contract::create($data);
        return $contract;
    }

    public function update($data){
        $contract = Contract::find($data['contract_id']);

        unset($data['contract_id']);

        $contract->update($data);
        return $contract;
    }
}

?>
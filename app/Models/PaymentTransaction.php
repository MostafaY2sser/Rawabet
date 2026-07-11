<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentStatus;

class PaymentTransaction extends Model
{
    public $table  = 'payment_transactions';
    public $guarded = ['id'];
    
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
  

    public function sender()
    {
        return $this->morphTo();
    }

    public function beneficiary()
    {
        return $this->morphTo();
    }

    public function payementStage(){
        return $this->belongsTo(PaymentSchedule::class , "payment_schedule_id");
    }
    public function contract(){
        return $this->belongsTo(Contract::class);
    }
}
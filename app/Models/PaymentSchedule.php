<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    use HasFactory;

    public $guarded=["id"];
    public $table = "payment_schedules";
    public function offerItem(){
        return $this->belongsTo(OfferItem::class , "stage_id");
    }
    public function offer(){
        return $this->belongsTo(Offer::class , "offer_id");
    }
}

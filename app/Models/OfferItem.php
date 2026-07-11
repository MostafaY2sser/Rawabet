<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferItem extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $casts = [
    'start_date' => 'date',
];

public function Inspection()
{
    return $this->hasOne(Inspection::class, 'offer_item_id')->latestOfMany();
}

public function offer(){
    return $this->belongsTo(Offer::class);
}

public function attachments(){
    return $this->hasMany(OfferItemImage::class , 'offer_item_id');
}

public function paymentSchedule(){
    return $this->hasOne(PaymentSchedule::class , "stage_id");
}
}


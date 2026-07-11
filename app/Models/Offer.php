<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function items()
    {
        return $this->hasMany(OfferItem::class, 'offer_id')->where('type', 'provider');
    }
    

    public function additionalServices()
    {
        return $this->hasMany(OfferItem::class, 'offer_id')->where('type', 'admin');
    }

    public function itemsWithSelectedServices()
    {
        return $this->hasMany(OfferItem::class, 'offer_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function buildingType()
    {
        return $this->belongsTo(BuildingType::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function paymentSchedules()
    {
        return $this->hasMany(PaymentSchedule::class, 'offer_id');
    }

    public function deposite()
    {
        return $this->paymentSchedules()->where('type', 'deposite')->first();
    }
}

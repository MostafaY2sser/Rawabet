<?php

namespace App\Models;

use App\Enums\OfferItemStatus;
use App\Enums\OfferStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    protected $casts = [
        'open_for_offers_date' => 'date',
        'accept_offer_date' => 'date',
    ];

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type', 'id');
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
    public function ServiceType()
    {
        return $this->belongsTo(Speciality::class, 'service_type');
    }

    public function buildingType()
    {
        return $this->belongsTo(BuildingType::class, 'building_type');
    }

    public function TimeLineDuration()
    {
        return $this->belongsTo(TimeLineDuration::class, 'duration');
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function attachments()
    {
        return $this->hasMany(ProjectAttachment::class, 'project_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class, 'project_id');
    }

    public function firstInspection()
    {
        return $this->inspections()->where('type', 'first_inspection')->latest()->first();
    }
    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'consultant_id');
    }
    public function offers(){
        return $this->hasMany(Offer::class);
    }
    public function scopedProviders()
    {
        return $this->belongsToMany(
            Provider::class,
            'project_provider_scopes',
            'project_id',
            'provider_id'
        );
    }
     public function approvedOffers(){
        return $this->hasMany(Offer::class)->where('status' , OfferStatus::APPROVED->value);
    }
    public function acceptedOffer()
{
    return $this->offers()
        ->where(function ($query) {
            $query->where('status', OfferStatus::ACCEPTED->value)
                ->orWhere(function ($q) {
                    $q->where('status', OfferStatus::COMPLETED->value)
                      ->whereHas('itemsWithSelectedServices', function ($itemQuery) {
                          $itemQuery->where('status', '!=', OfferItemStatus::PAID->value);
                      });
                });
        })
        ->first();
}

public function completedOffer(){
    return $this->offers()->where('status' , OfferStatus::COMPLETED)->first();
}


    public function stageInspections()
    {
        return $this->inspections()->where('type', 'item_inspection')->get();
    }

    public function city(){
        return $this->belongsTo(City::class);
    }
    public function region(){
        return $this->belongsTo(Region::class);
    }
    
 

    public function reports(){
        return $this->hasMany(ProjectReport::class , 'project_id');
    }
    public function overAllProgress(){
        $offer=$this->acceptedOffer() ?? $this->completedOffer();
 
        $totalProgress = $offer->items()->sum('progress');

        $itemCount = $offer->items()->count();

    $overallProgress = $itemCount > 0 ? round($totalProgress / $itemCount, 2) : 0;

    return $overallProgress;
    }

    
    public function rating(){
        return $this->hasMany(Rating::class);
    }
}

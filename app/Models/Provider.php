<?php

namespace App\Models;

use App\Enums\OfferStatus;
use App\Enums\ProjectStatus;
use App\Models\Speciality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Provider extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

  

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function specializations()
    {
        return $this->belongsToMany(
            Speciality::class,
            'provider_specializations',
            'provider_id',
            'specialization_id'
        );
    }

    public function workRegions()
    {
        return $this->belongsToMany(
            Region::class,
            'provider_work_regions',
            'provider_id',
            'region_id'
        );
    }

     public function workCities()
    {
        return $this->belongsToMany(
            City::class,
            'provider_work_cities',
            'provider_id',
            'city_id'
        );
    }
    public function activeProjects()
    {
        return Project::where('status', ProjectStatus::IN_PROGRESS->value)
            ->whereHas('offers', function ($query) {
                $query->where('provider_id', $this->id)->where('status', OfferStatus::ACCEPTED->value); // or just 'active' if not using enum
            })
            ->get();
    }
    public function scopedProjects()
    {
        return $this->belongsToMany(
            Project::class,
            'project_provider_scopes',
            'provider_id',
            'project_id'
        );
    }



    public function notifications()
    {
        return $this->morphMany(Notification::class, 'resever');
    }
    
    public function city(){
        return $this->belongsTo(City::class);
    }
     public function region(){
        return $this->belongsTo(Region::class);
    }

    public function attachments(){
        return $this->hasMany(ProviderAttachment::class);
    }
     public function payments()
    {
        return $this->morphMany(PaymentTransaction::class, 'beneficiary');
    }

    public function ratingsQuery(){

        $ratingsQuery = Rating::where('rater_type' , Customer::class)->where('rated_id' , $this->id);

        return $ratingsQuery;
    }

    public function completedProjectsCount(){
        return $this->hasMany(Offer::class)->where('status', OfferStatus::COMPLETED->value)->count();
    }
}

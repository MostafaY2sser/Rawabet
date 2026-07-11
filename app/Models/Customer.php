<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guarded = [];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'resever', 'resever_type', 'resever_id');
    }
       public function payments()
    {
        return $this->morphMany(PaymentTransaction::class, 'sender');
    }
    public function ratingsQuery(){

        $ratingsQuery = Rating::where('rater_type' ,'<>', Customer::class)->where('rated_id' , $this->id);

        return $ratingsQuery;
    }

     public function city(){
        return $this->belongsTo(City::class);
    }
     public function region(){
        return $this->belongsTo(Region::class);
    }


}

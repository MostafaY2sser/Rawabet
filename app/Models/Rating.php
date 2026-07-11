<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    public $guarded =['id'];


    public function Project(){
        return $this->belongsTo(Project::class);
    }

    public function customer(){
        return $this->project->customer;
    }

    public function provider(){
       if($this->rater_type == Customer::class)
        {
            return $this->Project->completedOffer()->provider;
        }
    }
}

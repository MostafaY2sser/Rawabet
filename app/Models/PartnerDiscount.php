<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerDiscount extends Model
{
    use HasFactory;
    public $guarded = ['id'];
    public $table = 'partners_discounts';

    public function section(){
        return $this->belongsTo(PartnersSection::class , 'section_id');
    }
    public function partner(){
        return $this->belongsTo(Partner::class , 'partner_id');
    }
}


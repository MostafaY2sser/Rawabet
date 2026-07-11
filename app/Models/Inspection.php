<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function report()
    {
        return $this->hasOne(InspectionReport::class)->latestOfMany();
    }

    public function stage()
    {
        return $this->belongsTo(OfferItem::class, 'offer_item_id');
    }

    public function inspector()
    {
        return $this->belongsTo(Consultant::class, 'consultant_id');
    }
}

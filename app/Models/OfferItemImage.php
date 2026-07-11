<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferItemImage extends Model
{
    use HasFactory;
    public $table = "offer_item_images";
    public $guarded = ["id"];
}

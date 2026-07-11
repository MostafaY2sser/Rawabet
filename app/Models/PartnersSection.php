<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnersSection extends Model
{
    use HasFactory;

    public $table ='partners_discounts_sections';
    public $guarded =['id'];
}

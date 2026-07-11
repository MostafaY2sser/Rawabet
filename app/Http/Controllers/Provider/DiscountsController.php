<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\PartnerDiscount;
use App\Models\PartnersSection;
use Illuminate\Http\Request;

class DiscountsController extends Controller
{
     public function index(){
        $discounts = PartnerDiscount::orderBy('id' , 'desc')->get();

        $sections = PartnersSection::all();
        $partners = Partner::all();
        return view('provider.discounts.index' , compact('discounts' , 'partners' , 'sections'));
    }
}

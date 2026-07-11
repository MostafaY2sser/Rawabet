<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\PartnerDiscount;
use App\Models\PartnersSection;
use Illuminate\Http\Request;

class DiscountsController extends Controller
{
    //
    public function index(){
        $discounts = PartnerDiscount::orderBy('id' , 'desc')->get();

        $sections = PartnersSection::all();
        $partners = Partner::all();
        return view('customer.discounts.index' , compact('discounts' , 'partners' , 'sections'));
    }
}

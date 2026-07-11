<?php
namespace App\Utils;

use App\Models\PaymentSchedule;

class Utility
{
    public static function formatDate($date, $format = 'Y-m-d')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }

    public static function generateUUID()
    {
        return \Illuminate\Support\Str::uuid()->toString();
    }

    public static function getOfferDepisite($offer_id){
        return PaymentSchedule::find(1);
    }

    public static function getPaymentSchedule($offer_id){

         return PaymentSchedule::all()->take(5);
    }

    
    // Add more utility methods here
}

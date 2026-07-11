<?php

use App\Models\Offer;
use App\Models\Setting;

function getsetting($key)
{
    return Setting::where('key', $key)->first()->value;
}

function getTaxPercentage(?Offer $offer = null): float
{
    if ($offer) {
        $contract = $offer->relationLoaded('contract') ? $offer->contract : $offer->contract()->first();

        if ($contract && $contract->tax_percentage !== null) {
            return (float) $contract->tax_percentage;
        }
    }

    return (float) getsetting('tax_percentage');
}

function getTaxAmount($amount, $taxPercentage = null)
{
    $rate = $taxPercentage ?? getTaxPercentage();

    return $amount * ($rate / 100);
}
<?php

namespace App\Jobs;

use App\Enums\OfferStatus;
use App\Models\Offer;
use App\Models\Setting;
use Illuminate\Foundation\Bus\Dispatchable;

class ExpireOffersToDraftJob
{
    use Dispatchable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $offerDays = (int) Setting::where('key', 'offer_days')->value('value');
        if ($offerDays <= 0) {
            return;
        }

        Offer::whereIn('status', [
            OfferStatus::PENDING->value,
            OfferStatus::APPROVED->value,
        ])
            ->where('created_at', '<=', now()->subDays($offerDays))
            ->update(['status' => OfferStatus::DRAFT->value]);
    }
}

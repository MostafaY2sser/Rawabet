<?php

namespace App\Observers;

use App\Models\Offer;
use App\Utils\NotificationUtility;

class OfferObserver
{
    /**
     * Handle the Offer "updated" event.
     */
    public function updated(Offer $offer)
    {
        $provider = $offer->provider;
        if ($offer->isDirty('status')) {
            $status = $offer->status;

            $replacements = [
                'project' => $offer->project->serviceType?->name . ' ' . $offer->project->buildingType?->name,
                'updated_at' => $offer->updated_at->format('Y-m-d H:i'),
            ];

            switch ($status) {
                case 'require_update':
                    NotificationUtility::sendToProvider(
                        $provider,
                        'offer_require_update',
                        route('provider.offers.show', $offer->id),
                        $replacements
                    );
                    break;

                case 'approved':
                    NotificationUtility::sendToProvider(
                        $provider,
                        'offer_approved',
                        route('provider.offers.show', $offer->id),
                        $replacements
                    );
                    NotificationUtility::sendToCustomer(
                        $offer->project->customer,
                        'new_offer',
                        route('customer.offer.index', $offer->project->id),
                        $replacements
                    );
                    break;

                case 'pending':
                    NotificationUtility::sendToProvider(
                        $provider,
                        'offer_pending',
                        route('provider.offers.show', $offer->id),
                        $replacements
                    );
                    break;

                case 'accepted':
                    NotificationUtility::sendToProvider(
                        $provider,
                        'offer_accepted',
                        route('provider.offers.show', $offer->id),
                        $replacements
                    );
                        NotificationUtility::sendToAdminWIthPermission(['view projects.workstages' , 'update projects.workstages'] , 'offer_accepted' , route('admin.projects.active.workstages' , $offer->project->id) , ['project' => ($offer->project->serviceType?->name . ' ' . $offer->project->buildingType?->name) ?? 'مشروع'] );

                    break;

                case 'completed':
                    NotificationUtility::sendToProvider(
                        $provider,
                        'offer_completed',
                        route('provider.offers.show', $offer->id),
                        $replacements
                    );
                    break;

                case 'declined':
                    NotificationUtility::sendToProvider(
                        $provider,
                        'offer_declined',
                        route('provider.offers.show', $offer->id),
                        $replacements
                    );
                    break;
            }
        }
    }

    public function created(Offer $offer)
    {
        NotificationUtility::sendToAdminWIthPermission(['edit offers.pending'], 'admin_new_offer', route('admin.offers.pending.edit', $offer->id), ['project' => ($offer->project->serviceType?->name . ' ' . $offer->project->buildingType?->name) ?? 'مشروع']);
    }
}

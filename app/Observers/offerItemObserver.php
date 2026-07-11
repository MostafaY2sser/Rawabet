<?php

namespace App\Observers;

use App\Models\OfferItem;
use App\Utils\NotificationUtility;

class OfferItemObserver
{
    public function updated(OfferItem $offerItem)
    {
        $statusChanged = $offerItem->isDirty('status');
        $progressChanged = $offerItem->isDirty('progress');

        // Skip if neither changed
        if (! $statusChanged && ! $progressChanged) {
            return;
        }

        // Related models
        $offer = $offerItem->offer;
        $project = $offer->project;
        $customer = $project->customer;
        $provider = $offer->provider;

        // Shared data
        $stageName = $offerItem->title ?? 'مرحلة';
        $projectName = ($project->serviceType?->name . ' ' . $project->buildingType?->name) ?? 'مشروع';

        $placeholders = [
            'stage'   => $stageName,
            'project' => $projectName,
        ];

        $adminUrl = route('admin.projects.active.workstages', $project->id);
        $customerUrl = route('customer.project.implementation.index', $project->id);
        $providerUrl = route('provider.project.implementation.index', $project->id); // adjust if needed

        // 🎯 If status changed, handle based on new value
        if ($statusChanged) {
            $newStatus = $offerItem->status;

            if ($newStatus === 'request_payment') {
                // Notify customer
                NotificationUtility::sendToCustomer(
                    $customer,
                    'offer_item_request_payment',
                    $customerUrl,
                    $placeholders
                );

                // Notify provider
                NotificationUtility::sendToProvider(
                    $provider,
                    'offer_item_request_payment',
                    $providerUrl,
                    $placeholders
                );

                return;
            }

            if ($newStatus === 'paid') {
                // Notify provider
                NotificationUtility::sendToProvider(
                    $provider,
                    'offer_item_paid',
                    $providerUrl,
                    $placeholders
                );

                // Notify admin
                NotificationUtility::sendToAdminWIthPermission(
                     ['update projects.workstages' , 'view projects.workstages'] ,
                    'offer_item_paid',
                    $adminUrl,
                    $placeholders
                );

                return;
            }
        }

        // 🎯 If progress changed (and status didn’t trigger a return above)
        if ($progressChanged) {
            NotificationUtility::sendToAdminWIthPermission(
                ['update projects.workstages' , 'view projects.workstages']  ,
                'offer_item_progress_updated',
                $adminUrl,
                $placeholders
            );

            NotificationUtility::sendToCustomer(
                $customer,
                'offer_item_progress_updated',
                $customerUrl,
                $placeholders
            );
        }
    }
}

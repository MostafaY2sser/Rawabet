<?php
namespace App\Utils;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Provider;
use App\Services\FirebaseService;

class NotificationUtility
{
    public static function sendToProvider(Provider $provider, $key, $url, $replacements = [])
    {
        $notification = config('nofications.types')[$key];

        $title = $notification['title'];
        $description = $notification['description'];

        foreach ($replacements as $keyRep => $value) {
            $title = str_replace(':' . $keyRep, $value, $title);
            $description = str_replace(':' . $keyRep, $value, $description);
        }

        $notificationObj = new Notification([
            'title' => $title,
            'description' => $description,
            'icon' => $notification['icon'],
            'class' => $notification['class'],
            'url' => $url
        ]);

        $notificationObj->resever()->associate($provider);
        $notificationObj->save();
                if($provider->fcm_token){

        FirebaseService::sendToToken(
            $provider->fcm_token,
            $title,
            $description,
            ['url' => $url]
        );
    }

        return $notificationObj;
    }

    public static function sendToCustomer(Customer $customer, $key, $url, $replacements = [])
    {
        $notification = config('nofications.types')[$key];
        $title = $notification['title'];
        $description = $notification['description'];

        foreach ($replacements as $keyRep => $value) {
            $title = str_replace(':' . $keyRep, $value, $title);
            $description = str_replace(':' . $keyRep, $value, $description);
        }

        $notificationObj = new Notification([
            'title' => $title,
            'description' => $description,
            'icon' => $notification['icon'],
            'class' => $notification['class'],
            'url' => $url
        ]);

        $notificationObj->resever()->associate($customer);
        $notificationObj->save();

        //
        if($customer->fcm_token){
        FirebaseService::sendToToken(
            $customer->fcm_token,
            $title,
            $description,
            ['url' => $url]
        );
    }
        return $notificationObj;
    }

    public static function sentToAdmin(Admin $admin, $key, $url, $replacements = [])
    {
        $notification = config('nofications.types')[$key];
        $title = $notification['title'];
        $description = $notification['description'];

        foreach ($replacements as $keyRep => $value) {
            $title = str_replace(':' . $keyRep, $value, $title);
            $description = str_replace(':' . $keyRep, $value, $description);
        }

        $notificationObj = new Notification([
            'title' => $title,
            'description' => $description,
            'icon' => $notification['icon'],
            'class' => $notification['class'],
            'url' => $url
        ]);

        $notificationObj->resever()->associate($admin);
        $notificationObj->save();

        if($admin->fcm_token){
        FirebaseService::sendToToken(
            $admin->fcm_token,
            $title,
            $description,
            ['url' => $url]
        );
    }
        return $notificationObj;
    }

    static function sendToAdminWIthPermission($permissions, $key, $url, $replacements = [])
    {
        $admins = Admin::all();

        foreach ($admins as $admin) {
            // Assuming a method like this exists on Admin to check permissions
            if ($admin->canAny($permissions)) {
                self::sentToAdmin(
                    $admin,
                    $key,
                    $url,
                    $replacements
                );
            }
        }
    }

    static function sendToAdminWIthId($id, $key, $url, $replacements = [])
    {
        $admin = Admin::find($id);

        // Assuming a method like this exists on Admin to check permissions
        self::sentToAdmin(
            $admin,
            $key,
            $url,
            $replacements
        );
    }
}

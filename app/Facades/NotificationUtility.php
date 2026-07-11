<?php 
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class NotificationUtility extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'NotificationUtility';
    }
}

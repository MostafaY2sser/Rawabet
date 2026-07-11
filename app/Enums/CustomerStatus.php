<?php

namespace App\Enums;

enum CustomerStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case REQUIREUPDATE = 'require_update';


    public static function getLabel(string $status): string
    {
        return match ($status) {
            self::ACTIVE->value => 'نشط',
            self::PENDING->value   => 'معلق',
     
            self::REQUIREUPDATE->value=>'يحتاج تعديل',


            default => 'غير معروف',
        };
    }
   

   
}

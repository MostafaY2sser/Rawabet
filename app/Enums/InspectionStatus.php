<?php

namespace App\Enums;

enum InspectionStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';

    public static function getLabel(string $status): string
    {
        return match ($status) {
            self::PENDING->value   => 'معلقه',
            self::COMPLETED->value  => ' مكتمل',
            self::CANCELED->value  => ' ملغي',
            default => 'غير معروف',
        };
    }



   
   

   
}

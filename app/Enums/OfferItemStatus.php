<?php

namespace App\Enums;

enum OfferItemStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case REQUESTPAYMENT = 'request_payment';
    case PAID = 'paid';

    public static function getLabel(string $status): string
    {
        return match ($status) {
            self::ACTIVE->value => 'قيد التنفيذ',
            self::PENDING->value   => 'معلقه',
            self::PAID->value  => 'مدفوع',
            self::COMPLETED->value  => ' مكتمل',
            self::REQUESTPAYMENT->value  => ' بانتظار الدفع',


            default => 'غير معروف',
        };
    }
   

   
}

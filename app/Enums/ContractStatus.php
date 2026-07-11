<?php

namespace App\Enums;

enum ContractStatus: string
{
    case PENDING = 'pending';  
    case ACTIVE = 'active';  
    case CANCELLED = 'cancelled';  
  

    
    // public static function getLabel(string $status): string
    // {
    //     // return match ($status) {
    //     //     self::REQUIRE_COMPLETE->value => 'يحتاج إلى استكمال',
    //     //     self::PENDING->value => 'قيد المراجعة',
    //     //     self::ACCEPTED->value => 'تم القبول',
    //     //     self::FIRST_INSPECTION_SCHEDULED->value => 'تم جدولة المعاينة',
    //     //     self::FIRST_INSPECTION_COMPLETED->value => 'اكتملت المعاينة',
    //     //     self::OPEN_FOR_OFFERS->value => 'متاح للعروض',
    //     //     self::IN_PROGRESS->value => 'قيد التنفيذ',
    //     //     self::COMPLETED->value => 'مكتمل',
    //     //     self::CANCELLED->value => 'ملغى',
    //     //     default => 'غير معروف',
    //     // };
    // }

   
}






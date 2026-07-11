<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case REQUIRE_COMPLETE = 'require_complete';  // still missing some information
    case PENDING = 'pending';   // submitted but not accepted by admin
    case ACCEPTED = 'accepted';  // accepted by admin, waiting for execution  and supervisor assigned
    case FIRST_INSPECTION_SCHEDULED = 'first_inspection_scheduled';  // first inspection scheduled
    case FIRST_INSPECTION_COMPLETED = 'first_inspection_completed';  // first inspection
    case OPEN_FOR_OFFERS = 'open_for_offers'; 
    case IN_PROGRESS = 'in_progress';  // currently being worked on
    case COMPLETED = 'completed';  // finished
    case CANCELLED = 'cancelled';  // stopped

    
    public static function getLabel(string $status): string
    {
        return match ($status) {
            self::REQUIRE_COMPLETE->value => 'يحتاج إلى استكمال',
            self::PENDING->value => 'قيد المراجعة',
            self::ACCEPTED->value => 'تم القبول',
            self::FIRST_INSPECTION_SCHEDULED->value => 'تم جدولة المعاينة',
            self::FIRST_INSPECTION_COMPLETED->value => 'اكتملت المعاينة',
            self::OPEN_FOR_OFFERS->value => 'متاح للعروض',
            self::IN_PROGRESS->value => 'قيد التنفيذ',
            self::COMPLETED->value => 'مكتمل',
            self::CANCELLED->value => 'ملغى',
            default => 'غير معروف',
        };
    }

   public static function getStatusOrder(string $status){
    return match ($status) {
            self::REQUIRE_COMPLETE->value => 1,
            self::PENDING->value =>1,
            self::ACCEPTED->value => 2,
            self::FIRST_INSPECTION_SCHEDULED->value =>3,
            self::FIRST_INSPECTION_COMPLETED->value => 4,
            self::OPEN_FOR_OFFERS->value => 5,
            self::IN_PROGRESS->value => 6,
            self::COMPLETED->value =>7,
            self::CANCELLED->value => 8,
            default => 0,
        };
   }

   public static function getPendingStatuess(){
    return [self::PENDING , self::REQUIRE_COMPLETE , self::FIRST_INSPECTION_COMPLETED , self::FIRST_INSPECTION_COMPLETED];
   }

   public static function getActiveStatuess(){
    return [self::OPEN_FOR_OFFERS , self::IN_PROGRESS];
   }

}






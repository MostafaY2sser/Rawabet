<?php

namespace App\Enums;

enum OfferStatus: string
{
    case REQUIRE_UPDATE = 'require_update';
    case APPROVED = 'approved';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case COMPLETED = 'completed';
    case DECLINED = 'declined';
    case DRAFT = 'draft';

    public static function getLabel(string $status): string
    {
        return match ($status) {
            self::REQUIRE_UPDATE->value => ' يحتاج تعديل في الاسعار',
            self::APPROVED->value => 'العرض متاح',
            self::PENDING->value => 'قيد المراجعة',
            self::ACCEPTED->value => 'تم القبول',
            self::DECLINED->value => 'لا يتوافق مع المتطلبات',
            self::COMPLETED->value => 'مكتمل',
            self::DRAFT->value => 'مسودة',
            default => 'غير معروف',
        };
    }

    public static function shortStatus(string $status): string
    {
        return match ($status) {
            self::APPROVED->value => 'معتمد',
            self::PENDING->value => 'قيد المراجعة',
            self::ACCEPTED->value => 'مقبول',
            self::DECLINED->value => 'مرفوض',
            self::REQUIRE_UPDATE->value => 'يحتاج تعديل',
            self::COMPLETED->value => 'مكتمل',
            self::DRAFT->value => 'مسودة',

            default => 'غير معروف',
        };
    }

    public static function getIcon(string $status): string
    {
        return match ($status) {
            self::APPROVED->value => 'fa-regular fa-circle-check',
            self::PENDING->value => 'fa-regular fa-clock',
            self::ACCEPTED->value => 'fa-solid fa-thumbs-up',
            self::DECLINED->value => 'fa-solid fa-xmark',
            self::REQUIRE_UPDATE->value => 'fa-solid fa-pen-to-square',
            self::DRAFT->value => 'fa-regular fa-file-lines',
            default => 'fa-regular fa-circle-question',
        };
    }

    public static function getClass(string $status): string
    {
        return match ($status) {
            self::APPROVED->value => 'approved',
            self::PENDING->value => 'pending',
            self::ACCEPTED->value => 'accepted',
            self::DECLINED->value => 'cancelled',
            self::REQUIRE_UPDATE->value => 'need-edit',
            self::DRAFT->value => 'pending',
            default => '',
        };
    }
    public static function getActiveStatuess(){
    return [self::APPROVED , self::ACCEPTED];
   }

}

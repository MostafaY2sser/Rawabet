<?php
namespace App\Enums;


enum PaymentStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case PROCESSING = 'processing';
    case FAILED = 'failed';
    case HOLD = 'hold';
    
     public function label(): string
    {
        return match ($this) {
            self::PENDING => 'في الانتظار',
            self::COMPLETED => 'مكتمل',
            self::PROCESSING => 'قيد المعالجة',
            self::FAILED => 'فشل',
            self::HOLD => 'قيد المعالجة',
        };
    }
     static function getLabel($status): string
{
    if (is_string($status)) {
        $status = PaymentStatus::tryFrom($status);
    }

    return match ($status) {
        self::PENDING => 'في الانتظار',
        self::COMPLETED => 'مكتمل',
        self::PROCESSING => 'قيد المعالجة',
        self::FAILED => 'فشل',
        self::HOLD => 'قيد المعالجة',
        default => 'غير معروف',
    };
}

    
    public function color(): string
    {
        
        return match ($this) {
            self::PENDING => 'text-blue-500',    
            self::COMPLETED => 'text-green-500',
            self::HOLD => 'text-yellow-500',
            self::FAILED => 'text-red-500',
        };
    }
    static function getColor($status): string
    {
        if (is_string($status)) {
        $status = PaymentStatus::tryFrom($status);
    }

        return match ($status) {
            self::PENDING => 'text-blue-500',    
            self::COMPLETED => 'text-green-500',
            self::HOLD => 'text-yellow-500',
            self::FAILED => 'text-red-500',
        };
    }
}
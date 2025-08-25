<?php

namespace App\Entity\Product;

enum ProductDemonstrationStatus: string
{
    case Requested = 'requested';
    case Handling = 'handling';
    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    /**
     * @return string[]
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}

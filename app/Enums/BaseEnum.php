<?php

namespace App\Enums;

trait BaseEnum
{
    /**
     * Returns enum values as an array.
     */
    public static function valueArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}

<?php

namespace App\Enums;

trait PHP8BaseEnum
{
    /**
     * Returns enum values as an array.
     */
    public static function valueArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Returns enum values as a list.
     */
    public static function valueList(string $separator = ', '): string
    {
        return implode($separator, self::valueArray());
    }
}

<?php

namespace Source\Shared\Enums\Traits;

trait UseEnumToArrayTrait
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        $values = array_column(self::cases(), 'value');

        if (! count($values)) {
            $values = array_column(self::cases(), 'name');
        }

        return $values;
    }

    public static function toArray(): array
    {
        $values = array_column(self::cases(), 'value');

        if (! count($values)) {
            return self::names();
        }

        return array_combine(self::values(), self::names());
    }
}

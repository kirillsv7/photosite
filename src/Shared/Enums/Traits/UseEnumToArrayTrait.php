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

        /** @phpstan-ignore booleanNot.alwaysTrue */
        if (!count($values)) {
            $values = array_column(self::cases(), 'name');
        }

        return $values;
    }

    public static function toArray(): array
    {
        $values = array_column(self::cases(), 'value');

        /** @phpstan-ignore booleanNot.alwaysTrue */
        if (!count($values)) {
            return self::names();
        }

        /** @phpstan-ignore deadCode.unreachable */
        return array_combine(self::values(), self::names());
    }
}

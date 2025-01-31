<?php

namespace Source\Shared\Enums\Contracts;

interface EnumToArray
{
    /**
     * @return array<int, string>
     */
    public static function names(): array;

    /**
     * @return array<int, string>
     */
    public static function values(): array;

    /**
     * @return array<int|string, string>
     */
    public static function toArray(): array;
}

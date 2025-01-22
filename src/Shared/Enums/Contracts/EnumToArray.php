<?php

namespace Source\Shared\Enums\Contracts;

interface EnumToArray
{
    public static function names(): array;

    public static function values(): array;

    public static function toArray(): array;
}

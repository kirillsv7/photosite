<?php

namespace Source\Shared\Enums\Contracts;

interface EnumFromName
{
    public static function tryFromName(string $name): ?static;

    public static function fromName(string $modelName): static;
}

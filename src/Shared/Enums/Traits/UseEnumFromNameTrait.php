<?php

namespace Source\Shared\Enums\Traits;

trait UseEnumFromNameTrait
{
    public static function tryFromName(string $name): ?static
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }

    public static function fromName(string $name): static
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        throw new \ValueError(
            sprintf('%s is not a valid backing value for enum %s', $name, self::class)
        );
    }
}

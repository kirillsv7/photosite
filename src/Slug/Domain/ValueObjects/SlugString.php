<?php

namespace Source\Slug\Domain\ValueObjects;

use Illuminate\Support\Str;
use Source\Shared\ValueObjects\StringValueObject;

final readonly class SlugString extends StringValueObject
{
    public static function fromFragments(array $fragments): self
    {
        return new self(implode(
            DIRECTORY_SEPARATOR,
            array_map(
                fn (string $fragment) => Str::slug($fragment),
                $fragments
            )
        ));
    }
}

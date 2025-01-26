<?php

namespace Source\MediaFile\Domain\ValueObjects;

use Source\Shared\ValueObjects\StringValueObject;

final readonly class SavedFile
{
    public function __construct(
        public StringValueObject $disk,
        public StringValueObject $route,
        public StringValueObject $name
    ) {
    }
}

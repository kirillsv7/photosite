<?php

namespace Source\MediaFile\Domain\ValueObjects;

final readonly class SavedFile
{
    public function __construct(
        public string $disk,
        public string $route,
        public string $name
    ) {
    }
}

<?php

namespace Source\MediaFile\Domain\Entities;


use Source\Shared\ValueObjects\StringValueObject;

final readonly class StorageInfo
{
    protected function __construct(
        public StringValueObject $disk,
        public StringValueObject $route,
        public StringValueObject $fileName,
    ) {
    }

    public static function make(
        StringValueObject $disk,
        StringValueObject $route,
        StringValueObject $fileName,
    ): self {
        return new self(
            disk: $disk,
            route: $route,
            fileName: $fileName
        );
    }

    public function toArray(): array
    {
        return [
            'disk' => $this->disk->toPrimitive(),
            'route' => $this->route->toPrimitive(),
            'fileName' => $this->fileName->toPrimitive(),
        ];
    }
}

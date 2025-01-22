<?php

namespace Source\MediaFile\Domain\Contracts;

use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\UuidInterface;
use Source\Shared\ValueObjects\StringValueObject;

interface MediaFileRouteGenerator
{
    public function __invoke(
        StringValueObject $mediaFolder,
        UuidInterface $mediableId,
        UploadedFile $uploadedFile
    ): string;
}

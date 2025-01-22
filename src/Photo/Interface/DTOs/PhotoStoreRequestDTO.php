<?php

namespace Source\Photo\Interface\DTOs;

use Illuminate\Http\UploadedFile;
use Source\Shared\ValueObjects\StringValueObject;

final readonly class PhotoStoreRequestDTO
{
    public function __construct(
        public ?StringValueObject $title,
        public UploadedFile $image,
    ) {
    }
}

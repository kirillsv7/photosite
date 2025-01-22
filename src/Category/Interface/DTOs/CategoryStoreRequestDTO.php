<?php

namespace Source\Category\Interface\DTOs;

use Illuminate\Http\UploadedFile;
use Source\Shared\ValueObjects\StringValueObject;

final readonly class CategoryStoreRequestDTO
{
    public function __construct(
        public StringValueObject $title,
        public ?StringValueObject $description,
        public ?UploadedFile $image,
    ) {
    }
}

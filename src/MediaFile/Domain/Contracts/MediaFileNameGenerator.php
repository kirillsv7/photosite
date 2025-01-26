<?php

namespace Source\MediaFile\Domain\Contracts;

use Illuminate\Http\UploadedFile;
use Source\Shared\ValueObjects\StringValueObject;

interface MediaFileNameGenerator
{
    public static function fileName(): StringValueObject;

    public function __invoke(UploadedFile $uploadedFile): StringValueObject;
}

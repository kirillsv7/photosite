<?php

namespace Source\MediaFile\Infrastructure\Services;

use Illuminate\Http\UploadedFile;
use Source\MediaFile\Domain\Contracts\MediaFileNameGenerator;
use Source\Shared\ValueObjects\StringValueObject;

final class GeneralMediaFileNameGenerator implements MediaFileNameGenerator
{
    public static function fileName(): StringValueObject
    {
        return StringValueObject::fromString('original');
    }

    public function __invoke(UploadedFile $uploadedFile): StringValueObject
    {
        return StringValueObject::fromArray('.', [
            self::fileName()->toPrimitive(),
            $uploadedFile->extension(),
        ]);
    }
}

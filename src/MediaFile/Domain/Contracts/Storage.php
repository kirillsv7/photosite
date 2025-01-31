<?php

namespace Source\MediaFile\Domain\Contracts;

use Illuminate\Http\UploadedFile;
use RuntimeException;
use Source\MediaFile\Domain\ValueObjects\SavedFile;
use Source\Shared\ValueObjects\StringValueObject;

interface Storage
{
    public static function disk(): StringValueObject;

    /**
     * @throws RuntimeException
     */
    public function saveFile(
        UploadedFile $file,
        StringValueObject $fileRoute,
        StringValueObject $fileName
    ): SavedFile;

    public function getFileUrl(
        StringValueObject $fileRoute,
        StringValueObject $fileName
    ): StringValueObject;
}

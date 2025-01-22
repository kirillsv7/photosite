<?php

namespace Source\MediaFile\Domain\Contracts;

use Illuminate\Http\UploadedFile;
use Source\MediaFile\Domain\ValueObjects\SavedFile;

interface Storage
{
    public function saveFile(
        UploadedFile $file,
        string $fileRoute,
        string $fileName
    ): SavedFile;

    public function getFileUrl(
        string $fileRoute,
        string $fileName
    ): string;
}

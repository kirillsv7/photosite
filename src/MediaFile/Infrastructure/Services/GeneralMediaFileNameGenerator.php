<?php

namespace Source\MediaFile\Infrastructure\Services;

use Illuminate\Http\UploadedFile;
use Source\MediaFile\Domain\Contracts\MediaFileNameGenerator;

final class GeneralMediaFileNameGenerator implements MediaFileNameGenerator
{
    public function __invoke(UploadedFile $uploadedFile): string
    {
        return 'original.' . $uploadedFile->extension();
    }
}

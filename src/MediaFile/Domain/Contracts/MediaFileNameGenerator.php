<?php

namespace Source\MediaFile\Domain\Contracts;

use Illuminate\Http\UploadedFile;

interface MediaFileNameGenerator
{
    public function __invoke(UploadedFile $uploadedFile): string;
}

<?php

namespace Source\MediaFile\Domain\Events;

use Source\MediaFile\Domain\Entities\MediaFile;

final readonly class MediaFileCreated
{
    public function __construct(
        public MediaFile $mediaFile,
    ) {
    }
}

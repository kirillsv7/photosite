<?php

namespace Source\MediaFile\Domain\Events;

use Source\MediaFile\Domain\Entities\MediaFile;
use Source\Shared\Events\Event;

final readonly class MediaFileCreatedEvent implements Event
{
    public function __construct(
        public MediaFile $mediaFile,
    ) {
    }
}

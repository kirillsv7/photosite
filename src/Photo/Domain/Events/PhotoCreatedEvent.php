<?php

namespace Source\Photo\Domain\Events;

use Source\Photo\Domain\Entities\Photo;
use Source\Shared\Events\Event;

final readonly class PhotoCreatedEvent implements Event
{
    public function __construct(
        public Photo $photo
    ) {
    }
}

<?php

namespace Source\Photo\Domain\Events;

use Source\Photo\Domain\Entities\Photo;

final readonly class PhotoCreated
{
    public function __construct(
        public Photo $photo
    ) {
    }
}

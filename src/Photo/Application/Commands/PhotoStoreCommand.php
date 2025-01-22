<?php

namespace Source\Photo\Application\Commands;

use Source\Photo\Domain\Entities\Photo;
use Source\Shared\Commands\Command;

final readonly class PhotoStoreCommand extends Command
{
    public function __construct(
        public Photo $photo,
    ) {
    }
}

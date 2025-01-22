<?php

namespace Source\Photo\Application\Commands;

use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\Shared\Commands\Command;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Entities\Slug;

final readonly class PhotoCreateCommand extends Command
{
    public function __construct(
        public UuidInterface $id,
        public StringValueObject $title,
        public MediaFile $image,
        public Slug $slug,
    ) {
    }
}

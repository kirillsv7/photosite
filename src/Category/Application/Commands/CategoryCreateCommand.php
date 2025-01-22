<?php

namespace Source\Category\Application\Commands;

use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\Shared\Commands\Command;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Entities\Slug;

final readonly class CategoryCreateCommand extends Command
{
    public function __construct(
        public UuidInterface $id,
        public StringValueObject $title,
        public ?StringValueObject $description,
        public ?MediaFile $image,
        public Slug $slug,
    ) {
    }
}

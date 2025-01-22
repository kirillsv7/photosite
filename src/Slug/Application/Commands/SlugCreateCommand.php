<?php

namespace Source\Slug\Application\Commands;

use Ramsey\Uuid\UuidInterface;
use Source\Shared\Commands\Command;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Enums\SluggableTypeEnum;

final readonly class SlugCreateCommand extends Command
{
    public function __construct(
        public StringValueObject $title,
        public UuidInterface $sluggableId,
        public SluggableTypeEnum $sluggableTypeEnum,
        public StringValueObject $slugBase,
    ) {
    }
}

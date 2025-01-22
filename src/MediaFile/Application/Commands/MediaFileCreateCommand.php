<?php

namespace Source\MediaFile\Application\Commands;

use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Enums\MediableTypeEnum;
use Source\Shared\Commands\Command;
use Source\Shared\ValueObjects\StringValueObject;

final readonly class MediaFileCreateCommand extends Command
{
    public function __construct(
        public UploadedFile $file,
        public UuidInterface $mediableId,
        public MediableTypeEnum $mediableTypeEnum,
        public StringValueObject $mediableFolder,
    ) {
    }
}

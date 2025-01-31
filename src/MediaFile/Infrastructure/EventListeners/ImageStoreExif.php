<?php

namespace Source\MediaFile\Infrastructure\EventListeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Source\MediaFile\Domain\Events\MediaFileCreated;
use Source\MediaFile\Infrastructure\Services\ImageExifReader;
use Source\Shared\ValueObjects\StringValueObject;
use Throwable;

final readonly class ImageStoreExif // implements ShouldQueue
{
    public function __construct(
        protected ImageExifReader $imageExifReader
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(
        MediaFileCreated $mediaFileCreated
    ): void {
        if (! $mediaFileCreated
            ->mediaFile
            ->mimetype
            ->equals(StringValueObject::fromString('image/jpeg'))
        ) {
            return;
        }

        $this->imageExifReader->process($mediaFileCreated->mediaFile);
    }
}

<?php

namespace Source\MediaFile\Infrastructure\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\CollectionInterface;
use Intervention\Image\Interfaces\ImageManagerInterface;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Repositories\MediaFileRepository;
use Source\Shared\ValueObjects\StringValueObject;
use Throwable;

final readonly class ImageExifReader
{
    public function __construct(
        protected ImageManagerInterface $imageManager,
        protected MediaFileRepository $repository,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function process(MediaFile $mediaFile): void
    {
        $mediaFileImage = Storage::disk($mediaFile->storageInfo->disk->toPrimitive())
            ->get(
                StringValueObject::fromArray(
                    DIRECTORY_SEPARATOR,
                    [
                        $mediaFile->storageInfo->route->toPrimitive(),
                        $mediaFile->fileName->toPrimitive(),
                    ]
                )
                    ->toPrimitive()
            );

        $image = $this->imageManager->read($mediaFileImage);

        /** @var CollectionInterface<string, mixed> $exif */
        $exif = $image->exif();

        /** @var array<string, mixed> $info */
        $info = $exif->toArray();

        $mediaFile->setInfo($info);

        $this->repository->update($mediaFile);
    }
}

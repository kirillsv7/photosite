<?php

namespace Source\MediaFile\Infrastructure\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\ImageManagerInterface;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Repositories\MediaFileRepository;
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
            ->get($mediaFile->storageInfo->route->toPrimitive().DIRECTORY_SEPARATOR.$mediaFile->fileName->toPrimitive());

        $image = $this->imageManager->read($mediaFileImage);

        $mediaFile->setInfo($image->exif()->toArray());

        $this->repository->update($mediaFile);
    }
}

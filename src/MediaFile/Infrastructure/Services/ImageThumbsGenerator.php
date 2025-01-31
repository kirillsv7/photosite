<?php

namespace Source\MediaFile\Infrastructure\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Interfaces\ImageManagerInterface;
use Source\MediaFile\Domain\Contracts\MediaFileNameGenerator;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Repositories\MediaFileRepository;
use Throwable;

final readonly class ImageThumbsGenerator
{
    public function __construct(
        protected ImageManagerInterface $imageManager,
        protected MediaFileNameGenerator $mediaFileNameGenerator,
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
                $mediaFile->storageInfo->route->toPrimitive().DIRECTORY_SEPARATOR.$mediaFile->fileName->toPrimitive()
            );

        $image = $this->imageManager->read($mediaFileImage);

        /** @var int[] $thumbSizes */
        $thumbSizes = config('mediafiles.thumb_sizes');

        foreach ($thumbSizes as $size) {
            if (
                $image->width() <= $size
                && $image->height() <= $size
            ) {
                continue;
            }

            $newSizeFileName = Str::replace(
                $this->mediaFileNameGenerator::fileName()->toPrimitive(),
                (string)$size,
                $mediaFile->fileName->toPrimitive()
            );

            $imageContent = $this->imageManager
                ->read($mediaFileImage)
                ->scaleDown($size, $size)
                ->toJpeg();

            Storage::disk($mediaFile->storageInfo->disk->toPrimitive())
                ->put(
                    implode(DIRECTORY_SEPARATOR, [
                        $mediaFile->storageInfo->route,
                        $newSizeFileName,
                    ]),
                    $imageContent
                );

            $mediaFile->addSize($size, $newSizeFileName);
        }

        $this->repository->update($mediaFile);
    }
}

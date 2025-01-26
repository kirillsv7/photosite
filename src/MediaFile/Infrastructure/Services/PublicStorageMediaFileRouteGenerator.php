<?php

namespace Source\MediaFile\Infrastructure\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Contracts\MediaFileRouteGenerator;
use Source\Shared\ValueObjects\StringValueObject;

final class PublicStorageMediaFileRouteGenerator implements MediaFileRouteGenerator
{
    public function __invoke(
        StringValueObject $mediaFolder,
        UuidInterface $mediableId,
        UploadedFile $uploadedFile
    ): StringValueObject {
        $rootFolder = 'media_files';

        $mimeTypeFolder = $this->guessFolderNameFromMimeType($uploadedFile);

        return StringValueObject::fromArray(DIRECTORY_SEPARATOR, [
            $rootFolder,
            $mediaFolder->toPrimitive(),
            $mediableId->toString(),
            $mimeTypeFolder->toPrimitive(),
            Str::before($uploadedFile->hashName(), '.'),
        ]);
    }

    private function guessFolderNameFromMimeType(UploadedFile $file): StringValueObject
    {
        $mimeType = $file->getMimeType();

        $folder = 'others';

        if (str_contains($mimeType, 'image')) {
            $folder = 'images';
        }
        if (str_contains($mimeType, 'video')) {
            $folder = 'videos';
        }
        if (str_contains($mimeType, 'pdf')) {
            $folder = 'documents';
        }

        return StringValueObject::fromString($folder);
    }
}

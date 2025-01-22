<?php

namespace Source\MediaFile\Infrastructure\Storages;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;
use Source\MediaFile\Domain\Contracts\Storage;
use Source\MediaFile\Domain\ValueObjects\SavedFile;

final class PublicStorage implements Storage
{
    protected const DISK = 'public';

    public function __construct(
        private readonly FilesystemManager $fileSystem
    ) {
    }

    public function saveFile(
        UploadedFile $file,
        string $fileRoute,
        string $fileName,
    ): SavedFile {
        $result = $this->fileSystem
            ->disk(self::DISK)
            ->put(
                implode(DIRECTORY_SEPARATOR, [
                    $fileRoute,
                    $fileName
                ]),
                $file->getContent()
            );

        if (!$result) {
            throw new \RuntimeException('File not saved');
        }

        return new SavedFile(
            disk: self::DISK,
            route: $fileRoute,
            name: $fileName,
        );
    }

    public function getFileUrl(
        string $fileRoute,
        string $fileName
    ): string {
        return $this->fileSystem->url(
            implode(DIRECTORY_SEPARATOR, [
                $fileRoute,
                $fileName
            ])
        );
    }
}

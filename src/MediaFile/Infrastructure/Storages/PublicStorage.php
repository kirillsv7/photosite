<?php

namespace Source\MediaFile\Infrastructure\Storages;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;
use RuntimeException;
use Source\MediaFile\Domain\Contracts\Storage;
use Source\MediaFile\Domain\ValueObjects\SavedFile;
use Source\Shared\ValueObjects\StringValueObject;

final class PublicStorage implements Storage
{
    protected const DISK = 'public';

    public function __construct(
        private readonly FilesystemManager $fileSystem
    ) {
    }

    public static function disk(): StringValueObject
    {
        return StringValueObject::fromString(self::DISK);
    }

    public function saveFile(
        UploadedFile $file,
        StringValueObject $fileRoute,
        StringValueObject $fileName,
    ): SavedFile {
        $result = $this->fileSystem
            ->disk(self::DISK)
            ->put(
                implode(DIRECTORY_SEPARATOR, [
                    $fileRoute->toPrimitive(),
                    $fileName->toPrimitive(),
                ]),
                $file->getContent()
            );

        if (! $result) {
            throw new RuntimeException('File not saved');
        }

        return new SavedFile(
            disk: self::disk(),
            route: $fileRoute,
            name: $fileName,
        );
    }

    public function getFileUrl(
        StringValueObject $fileRoute,
        StringValueObject $fileName
    ): StringValueObject {
        return StringValueObject::fromString(
            $this->fileSystem->url(
                StringValueObject::fromArray(
                    DIRECTORY_SEPARATOR,
                    [
                        $fileRoute->toPrimitive(),
                        $fileName->toPrimitive(),
                    ]
                )
                    ->toPrimitive()
            )
        );
    }
}

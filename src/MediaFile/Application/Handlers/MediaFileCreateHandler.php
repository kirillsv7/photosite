<?php

namespace Source\MediaFile\Application\Handlers;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\Uuid;
use Source\MediaFile\Application\Commands\MediaFileCreateCommand;
use Source\MediaFile\Domain\Contracts\MediaFileNameGenerator;
use Source\MediaFile\Domain\Contracts\MediaFileRouteGenerator;
use Source\MediaFile\Domain\Contracts\Storage;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Entities\StorageInfo;
use Source\Shared\Handlers\Handler;
use Source\Shared\ValueObjects\StringValueObject;

final readonly class MediaFileCreateHandler extends Handler
{
    public function __construct(
        protected MediaFileNameGenerator $mediaFileNameGenerator,
        protected MediaFileRouteGenerator $mediaFileRouteGenerator,
        protected Storage $storage,
    ) {
    }

    public function handle(MediaFileCreateCommand $command): MediaFile
    {
        $file = $command->file;

        $mediableId = $command->mediableId;

        $mediableFolder = $command->mediableFolder;

        $fileRoute = $this->mediaFileRouteGenerator->__invoke(
            $mediableFolder,
            $mediableId,
            $file,
        );

        $fileName = $this->mediaFileNameGenerator->__invoke($file);

        $savedFile = $this->storage->saveFile(
            file: $file,
            fileRoute: $fileRoute,
            fileName: $fileName,
        );

        return MediaFile::create(
            id: Uuid::uuid6(),
            originalFileName: StringValueObject::fromString($file->getClientOriginalName()),
            fileName: $savedFile->name,
            storageInfo: StorageInfo::make(
                disk: $savedFile->disk,
                route: $savedFile->route,
            ),
            sizes: [],
            extension: StringValueObject::fromString($file->extension()),
            mimetype: StringValueObject::fromString($file->getMimeType() ?? ''),
            info: [],
            mediableType: $command->mediableTypeEnum,
            mediableId: $mediableId,
            createdAt: CarbonImmutable::now(),
        );
    }
}

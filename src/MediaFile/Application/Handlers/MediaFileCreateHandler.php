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
    )
    {
    }

    public function handle(MediaFileCreateCommand $command)
    {
        $file = $command->file;

        $mediableId = $command->mediableId;

        $mediableFolder = $command->mediableFolder;

        $fileRoute = $this->mediaFileRouteGenerator->__invoke(
            $mediableFolder,
            $mediableId,
            $file,
        );

        $savedFile = $this->storage->saveFile(
            file: $file,
            fileRoute: $fileRoute,
            fileName: $this->mediaFileNameGenerator->__invoke($file)
        );

        return MediaFile::create(
            id: Uuid::uuid6(),
            originalName: StringValueObject::fromString($file->getClientOriginalName()),
            info: [],
            storageInfo: StorageInfo::make(
                disk: StringValueObject::fromString($savedFile->disk),
                route: StringValueObject::fromString($savedFile->route),
                fileName: StringValueObject::fromString($savedFile->name),
            ),
            sizes: [],
            mimetype: StringValueObject::fromString($file->getMimeType()),
            mediableType: $command->mediableTypeEnum,
            mediableId: $mediableId,
            createdAt: CarbonImmutable::now(),
        );
    }
}

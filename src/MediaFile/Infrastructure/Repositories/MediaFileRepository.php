<?php

namespace Source\MediaFile\Infrastructure\Repositories;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Entities\StorageInfo;
use Source\MediaFile\Domain\Enums\MediableTypeEnum;
use Source\MediaFile\Domain\Exceptions\MediaFileNotFoundException;
use Source\MediaFile\Domain\Repositories\MediaFileRepository as MediaFileRepositoryContract;
use Source\MediaFile\Infrastructure\Models\MediaFileModel;
use Source\Shared\ValueObjects\StringValueObject;

final class MediaFileRepository implements MediaFileRepositoryContract
{
    public function __construct(
        protected ConnectionInterface $connection
    ) {
    }

    public function get(UuidInterface $id): ?MediaFile
    {
        $mediaFileModel = MediaFileModel::query()
            ->where('id', $id->toString())
            ->first();

        if (!$mediaFileModel) {
            throw new MediaFileNotFoundException();
        }

        return $this->map($mediaFileModel);
    }

    public function create(MediaFile $mediaFile): void
    {
        $this->connection->transaction(function () use ($mediaFile) {
            $model = new MediaFileModel();

            $model->setAttribute('id', $mediaFile->id->toString());
            $model->setAttribute('original_name', $mediaFile->originalName->toPrimitive());
            $model->setAttribute('info', $mediaFile->info());
            $model->setAttribute('storage_info', $mediaFile->storageInfo->toArray());
            $model->setAttribute('sizes', $mediaFile->sizes());
            $model->setAttribute('mimetype', $mediaFile->mimetype->toPrimitive());
            $model->setAttribute('mediable_type', $mediaFile->mediableType->name);
            $model->setAttribute('mediable_id', $mediaFile->mediableId->toString());
            $model->setAttribute('created_at', Carbon::now());

            $model->save();
        });
    }

    public function update(UuidInterface $id, MediaFile $mediaFile): void
    {
        /** @var MediaFileModel $model */
        $model = MediaFileModel::query()->find($id);

        $this->connection->transaction(function () use ($model, $mediaFile) {
            $model->setAttribute('original_name', $mediaFile->originalName->toPrimitive());
            $model->setAttribute('info', $mediaFile->info());
            $model->setAttribute('storage_info', $mediaFile->storageInfo->toArray());
            $model->setAttribute('sizes', $mediaFile->sizes());
            $model->setAttribute('mimetype', $mediaFile->mimetype->toPrimitive());
            $model->setAttribute('mediable_type', $mediaFile->mediableType->name);
            $model->setAttribute('mediable_id', $mediaFile->mediableId->toString());
            $model->setAttribute('updated_at', Carbon::now());

            $model->save();
        });
    }

    public function getById(UuidInterface $id): ?MediaFile
    {
        /** @var ?MediaFileModel $model */
        $model = MediaFileModel::query()->find($id);

        if (!$model) {
            throw new MediaFileNotFoundException();
        }

        return self::map($model);
    }

    public function getByMediableId(UuidInterface $mediableId): ?MediaFile
    {
        /** @var ?MediaFileModel $model */
        $model = MediaFileModel::query()
            ->where('mediable_id', $mediableId->toString())
            ->first();

        if (!$model) {
            throw new MediaFileNotFoundException();
        }

        return self::map($model);
    }

    private function map(MediaFileModel $model): MediaFile
    {
        return MediaFile::make(
            id: Uuid::fromString($model->getAttribute('id')),
            originalName: StringValueObject::fromString($model->getAttribute('original_name')),
            info: $model->getAttribute('info'),
            storageInfo: StorageInfo::make(
                disk: StringValueObject::fromString($model->getAttribute('storage_info')['disk']),
                route: StringValueObject::fromString($model->getAttribute('storage_info')['route']),
                fileName: StringValueObject::fromString($model->getAttribute('storage_info')['fileName'])
            ),
            sizes: $model->getAttribute('sizes'),
            mimetype: StringValueObject::fromString($model->getAttribute('mimetype')),
            mediableType: MediableTypeEnum::fromName($model->getAttribute('mediable_type')),
            mediableId: Uuid::fromString($model->getAttribute('mediable_id')),
            createdAt: $model->getAttribute('created_at'),
            updatedAt: $model->getAttribute('updated_at'),
        );
    }
}

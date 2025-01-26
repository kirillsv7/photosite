<?php

namespace Source\MediaFile\Domain\Entities;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Enums\MediableTypeEnum;
use Source\MediaFile\Domain\Events\MediaFileCreated;
use Source\Shared\Entities\Contracts\AggregateWithEvents;
use Source\Shared\Entities\Contracts\Entity;
use Source\Shared\Entities\Traits\UseAggregateEvents;
use Source\Shared\ValueObjects\StringValueObject;

final class MediaFile implements Entity, AggregateWithEvents
{
    use UseAggregateEvents;

    protected function __construct(
        public readonly UuidInterface $id,
        public readonly StringValueObject $originalFileName,
        public readonly StringValueObject $fileName,
        public readonly StorageInfo $storageInfo,
        private array $sizes,
        public readonly StringValueObject $extension,
        public readonly StringValueObject $mimetype,
        private ?array $info,
        public readonly MediableTypeEnum $mediableType,
        public readonly UuidInterface $mediableId,
        public readonly ?CarbonImmutable $createdAt = null,
        public readonly ?CarbonImmutable $updatedAt = null
    ) {
    }

    public static function make(
        UuidInterface $id,
        StringValueObject $originalFileName,
        StringValueObject $fileName,
        StorageInfo $storageInfo,
        array $sizes,
        StringValueObject $extension,
        StringValueObject $mimetype,
        ?array $info,
        MediableTypeEnum $mediableType,
        UuidInterface $mediableId,
        ?CarbonImmutable $createdAt = null,
        ?CarbonImmutable $updatedAt = null,
    ): self {
        return new self(
            id: $id,
            originalFileName: $originalFileName,
            fileName: $fileName,
            storageInfo: $storageInfo,
            sizes: $sizes,
            extension: $extension,
            mimetype: $mimetype,
            info: $info,
            mediableType: $mediableType,
            mediableId: $mediableId,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public static function create(
        UuidInterface $id,
        StringValueObject $originalFileName,
        StringValueObject $fileName,
        StorageInfo $storageInfo,
        array $sizes,
        StringValueObject $extension,
        StringValueObject $mimetype,
        ?array $info,
        MediableTypeEnum $mediableType,
        UuidInterface $mediableId,
        ?CarbonImmutable $createdAt = null,
        ?CarbonImmutable $updatedAt = null,
    ): self {
        $mediaFile = self::make(
            id: $id,
            originalFileName: $originalFileName,
            fileName: $fileName,
            storageInfo: $storageInfo,
            sizes: $sizes,
            extension: $extension,
            mimetype: $mimetype,
            info: $info,
            mediableType: $mediableType,
            mediableId: $mediableId,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );

        $mediaFile->addEvent(new MediaFileCreated($mediaFile));

        return $mediaFile;
    }

    public function info(): array
    {
        return $this->info;
    }

    public function setInfo(array $info): void
    {
        $this->info = $info;
    }

    public function sizes(): array
    {
        return $this->sizes;
    }

    /** @return StringValueObject[] */
    public function filePaths(): array
    {
        $filePaths = [];

        foreach ($this->sizes as $size => $filename) {
            $filePaths[$size] = StringValueObject::fromArray(DIRECTORY_SEPARATOR, [
                $this->storageInfo->route->toPrimitive(),
                $filename,
            ]);
        }

        return $filePaths;
    }

    public function addSize(int $size, string $filename): void
    {
        $this->sizes[$size] = $filename;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'original_filename' => $this->originalFileName->toPrimitive(),
            'filename' => $this->fileName->toPrimitive(),
            'storage_info' => $this->storageInfo->toArray(),
            'sizes' => $this->sizes,
            'files' => array_map(fn(StringValueObject $filePath) => $filePath->toPrimitive(),$this->filePaths()),
            'extension' => $this->extension->toPrimitive(),
            'mimetype' => $this->mimetype->toPrimitive(),
            'info' => $this->info,
            'mediable_type' => $this->mediableType->name,
            'mediable_id' => $this->mediableId->toString(),
            'created_at' => $this->createdAt?->toDateTimeString(),
            'updated_at' => $this->updatedAt?->toDateTimeString(),
        ];
    }
}

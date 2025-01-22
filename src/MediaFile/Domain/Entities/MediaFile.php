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

    private function __construct(
        public readonly UuidInterface $id,
        public readonly StringValueObject $originalName,
        private ?array $info,
        public readonly StorageInfo $storageInfo,
        private array $sizes,
        public readonly StringValueObject $mimetype,
        public readonly MediableTypeEnum $mediableType,
        public readonly UuidInterface $mediableId,
        public readonly ?CarbonImmutable $createdAt = null,
        public readonly ?CarbonImmutable $updatedAt = null
    ) {
    }

    public static function make(
        UuidInterface $id,
        StringValueObject $originalName,
        ?array $info,
        StorageInfo $storageInfo,
        array $sizes,
        StringValueObject $mimetype,
        MediableTypeEnum $mediableType,
        UuidInterface $mediableId,
        ?CarbonImmutable $createdAt = null,
        ?CarbonImmutable $updatedAt = null,
    ): self {
        return new self(
            id: $id,
            originalName: $originalName,
            info: $info,
            storageInfo: $storageInfo,
            sizes: $sizes,
            mimetype: $mimetype,
            mediableType: $mediableType,
            mediableId: $mediableId,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public static function create(
        UuidInterface $id,
        StringValueObject $originalName,
        ?array $info,
        StorageInfo $storageInfo,
        array $sizes,
        StringValueObject $mimetype,
        MediableTypeEnum $mediableType,
        UuidInterface $mediableId,
        ?CarbonImmutable $createdAt = null,
        ?CarbonImmutable $updatedAt = null,
    ): self {
        $mediaFile = self::make(
            id: $id,
            originalName: $originalName,
            info: $info,
            storageInfo: $storageInfo,
            sizes: $sizes,
            mimetype: $mimetype,
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

    public function filePath(): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->storageInfo->route,
            $this->storageInfo->fileName,
        ]);
    }

    public function addSize(string $size): void
    {
        $this->sizes[] = $size;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'original_name' => $this->originalName->toPrimitive(),
            'info' => $this->info,
            'storage_info' => $this->storageInfo->toArray(),
            'sizes' => $this->sizes,
            'mimetype' => $this->mimetype->toPrimitive(),
            'mediableType' => $this->mediableType->name,
            'mediableId' => $this->mediableId->toString(),
            'createdAt' => $this->createdAt?->toDateTimeString(),
            'updatedAt' => $this->updatedAt?->toDateTimeString(),
        ];
    }
}

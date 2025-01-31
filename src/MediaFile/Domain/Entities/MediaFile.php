<?php

namespace Source\MediaFile\Domain\Entities;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Contracts\Storage;
use Source\MediaFile\Domain\Enums\MediableTypeEnum;
use Source\MediaFile\Domain\Events\MediaFileCreatedEvent;
use Source\Shared\Entities\Contracts\AggregateWithEvents;
use Source\Shared\Entities\Contracts\Entity;
use Source\Shared\Entities\Traits\UseAggregateEvents;
use Source\Shared\ValueObjects\StringValueObject;

final class MediaFile implements AggregateWithEvents, Entity
{
    use UseAggregateEvents;

    protected Storage $storage;

    /**
     * @param  array<int, string>  $sizes
     * @param  array<string, mixed>|null  $info
     */
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
        public readonly ?CarbonImmutable $updatedAt = null,
    ) {
        $this->storage = app(Storage::class);
    }

    /**
     * @param  array<int, string>  $sizes
     * @param  array<string, mixed>|null  $info
     */
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

    /**
     * @param  array<int, string>  $sizes
     * @param  array<string, mixed>|null  $info
     */
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

        $mediaFile->addEvent(new MediaFileCreatedEvent($mediaFile));

        return $mediaFile;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function info(): ?array
    {
        return $this->info;
    }

    /**
     * @param  array<string, mixed>|null  $info
     */
    public function setInfo(?array $info): void
    {
        $this->info = $info;
    }

    /**
     * @return array<int, string>
     */
    public function sizes(): array
    {
        return $this->sizes;
    }

    /**
     * @return array<int, string>
     */
    public function links(): array
    {
        $links = [];

        foreach ($this->sizes as $size => $filename) {
            $links[$size] = $this->storage
                ->getFileUrl(
                    $this->storageInfo->route,
                    StringValueObject::fromString($filename)
                )->toPrimitive();
        }

        return $links;
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
            'links' => $this->links(),
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

<?php

namespace Source\Photo\Domain\Entities;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Contracts\Mediable;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\Photo\Domain\Events\PhotoCreatedEvent;
use Source\Shared\Entities\Contracts\Entity;
use Source\Shared\Entities\Traits\UseAggregateEvents;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Contracts\Sluggable;
use Source\Slug\Domain\Entities\Slug;

final class Photo implements Entity, Mediable, Sluggable
{
    use UseAggregateEvents;

    protected function __construct(
        public readonly UuidInterface $id,
        public readonly StringValueObject $title,
        public readonly MediaFile $image,
        public readonly Slug $slug,
        public readonly ?CarbonImmutable $createdAt,
        public readonly ?CarbonImmutable $updatedAt,
    ) {
    }

    public static function make(
        UuidInterface $id,
        StringValueObject $title,
        MediaFile $image,
        Slug $slug,
        ?CarbonImmutable $createdAt = null,
        ?CarbonImmutable $updatedAt = null,
    ): self {
        return new self(
            id: $id,
            title: $title,
            image: $image,
            slug: $slug,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public static function create(
        UuidInterface $id,
        StringValueObject $title,
        MediaFile $image,
        Slug $slug,
        ?CarbonImmutable $createdAt = null,
        ?CarbonImmutable $updatedAt = null,
    ): self {
        $photo = self::make(
            id: $id,
            title: $title,
            image: $image,
            slug: $slug,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );

        $photo->addEvent(new PhotoCreatedEvent($photo));

        return $photo;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'title' => $this->title->toPrimitive(),
            'image' => $this->image->toArray(),
            'slug' => $this->slug->toArray(),
            'created_at' => $this->createdAt?->toDateTimeString(),
            'updated_at' => $this->updatedAt?->toDateTimeString(),
        ];
    }

    public static function getMediableFolder(): StringValueObject
    {
        return StringValueObject::fromString('photos');
    }

    public static function getSlugBase(): StringValueObject
    {
        return StringValueObject::fromString('photos');
    }
}

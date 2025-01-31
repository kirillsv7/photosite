<?php

namespace Source\Slug\Domain\Entities;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\UuidInterface;
use Source\Shared\Entities\Contracts\AggregateWithEvents;
use Source\Shared\Entities\Contracts\Entity;
use Source\Shared\Entities\Traits\UseAggregateEvents;
use Source\Slug\Domain\Enums\SluggableTypeEnum;
use Source\Slug\Domain\ValueObjects\SlugString;

final class Slug implements AggregateWithEvents, Entity
{
    use UseAggregateEvents;

    private function __construct(
        public readonly UuidInterface $id,
        public readonly SlugString $value,
        public readonly SluggableTypeEnum $sluggableType,
        public readonly UuidInterface $sluggableId,
        public readonly ?CarbonImmutable $createdAt,
        public readonly ?CarbonImmutable $updatedAt,
    ) {
    }

    public static function make(
        UuidInterface $id,
        SlugString $value,
        SluggableTypeEnum $sluggableType,
        UuidInterface $sluggableId,
        ?CarbonImmutable $createdAt = null,
        ?CarbonImmutable $updatedAt = null,
    ): Slug {
        return new self(
            id: $id,
            value: $value,
            sluggableType: $sluggableType,
            sluggableId: $sluggableId,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public static function create(
        UuidInterface $id,
        SlugString $value,
        SluggableTypeEnum $sluggableType,
        UuidInterface $sluggableId,
        ?CarbonImmutable $createdAt = null,
        ?CarbonImmutable $updatedAt = null,
    ): Slug {
        return self::make(
            id: $id,
            value: $value,
            sluggableType: $sluggableType,
            sluggableId: $sluggableId,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
        // TODO Add events
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'value' => $this->value->toPrimitive(),
            'sluggable_type' => $this->sluggableType->name,
            'sluggable_id' => $this->sluggableId->toString(),
            'created_at' => $this->createdAt?->toDateTimeString(),
            'updated_at' => $this->updatedAt?->toDateTimeString(),
        ];
    }
}

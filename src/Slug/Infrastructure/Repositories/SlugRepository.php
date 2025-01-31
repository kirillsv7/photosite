<?php

namespace Source\Slug\Infrastructure\Repositories;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Contracts\Sluggable;
use Source\Slug\Domain\Entities\Slug;
use Source\Slug\Domain\Enums\SluggableTypeEnum;
use Source\Slug\Domain\Exceptions\SlugNotFoundException;
use Source\Slug\Domain\Repositories\SlugRepository as SlugRepositoryContract;
use Source\Slug\Domain\ValueObjects\SlugString;
use Source\Slug\Infrastructure\Models\SlugModel;

final class SlugRepository implements SlugRepositoryContract
{
    public function __construct(
        protected ConnectionInterface $connection
    ) {
    }

    public function get(UuidInterface $id): Slug
    {
        $slugModel = SlugModel::query()
            ->where('id', $id->toString())
            ->first();

        if (!$slugModel) {
            throw new SlugNotFoundException();
        }

        return $this->map($slugModel);
    }

    public function getBySlug(StringValueObject $slug): Slug
    {
        $model = SlugModel::query()
            ->where('slug', $slug->toPrimitive())
            ->first();

        if (!$model) {
            throw new SlugNotFoundException();
        }

        return $this->map($model);
    }

    public function create(Slug $slug): void
    {
        $this->connection->transaction(function () use ($slug) {
            $model = new SlugModel();

            $model->setAttribute('id', $slug->id->toString());
            $model->setAttribute('slug', $slug->value->toPrimitive());
            $model->setAttribute('sluggable_type', $slug->sluggableType->name);
            $model->setAttribute('sluggable_id', $slug->sluggableId->toString());
            $model->setAttribute('created_at', Carbon::now());

            $model->save();
        });
    }

    public function update(Slug $slug): void
    {
        $model = SlugModel::query()->find($slug->id->toString());

        if (!$model) {
            throw new SlugNotFoundException();
        }

        $this->connection->transaction(function () use ($model, $slug) {
            $model->setAttribute('slug', $slug->value->toPrimitive());

            $model->save();
        });
    }

    public function getBySluggable(
        Sluggable $sluggableType,
        UuidInterface $sluggableId
    ): Slug {
        $model = SlugModel::query()
            ->where('sluggable_type', get_class($sluggableType))
            ->where('sluggable_id', $sluggableId)
            ->first();

        if (!$model) {
            throw new SlugNotFoundException();
        }

        return $this->map($model);
    }

    public function getBySluggableId(UuidInterface $id): Slug
    {
        $model = SlugModel::query()
            ->where('sluggable_id', $id->toString())
            ->first();

        if (!$model) {
            throw new SlugNotFoundException();
        }

        return $this->map($model);
    }

    private function map(SlugModel $model): Slug
    {
        return Slug::make(
            id: Uuid::fromString($model->id),
            value: SlugString::fromString($model->slug),
            sluggableType: SluggableTypeEnum::fromName($model->sluggable_type),
            sluggableId: Uuid::fromString($model->sluggable_id),
            createdAt: $model->created_at,
            updatedAt: $model->updated_at,
        );
    }
}

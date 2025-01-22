<?php

namespace Source\Slug\Domain\Repositories;

use Ramsey\Uuid\UuidInterface;
use Source\Shared\Repositories\Contracts\Repository;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Contracts\Sluggable;
use Source\Slug\Domain\Entities\Slug;
use Source\Slug\Domain\Exceptions\SlugNotFoundException;
use Throwable;

interface SlugRepository extends Repository
{
    /**
     * @throws SlugNotFoundException
     */
    public function get(UuidInterface $id): ?Slug;

    /**
     * @throws Throwable
     */
    public function create(Slug $slug): void;

    /**
     * @throws Throwable
     */
    public function update(Slug $slug): void;

    /**
     * @throws SlugNotFoundException
     */
    public function getBySlug(StringValueObject $slug): ?Slug;

    /**
     * @throws SlugNotFoundException
     */
    public function getBySluggable(Sluggable $sluggableType, UuidInterface $sluggableId): ?Slug;

    /**
     * @throws SlugNotFoundException
     */
    public function getBySluggableId(UuidInterface $id): ?Slug;
}

<?php

namespace Source\Category\Domain\Repositories;

use Ramsey\Uuid\UuidInterface;
use Source\Category\Domain\Entities\Category;
use Source\MediaFile\Domain\Exceptions\MediaFileNotFoundException;
use Source\Category\Domain\Exceptions\CategoryNotFoundException;
use Source\Shared\Repositories\Contracts\ResourceRepository;
use Source\Slug\Domain\Exceptions\SlugNotFoundException;
use Throwable;

interface CategoryRepository extends ResourceRepository
{
    /**
     * @throws CategoryNotFoundException
     * @throws MediaFileNotFoundException
     * @throws SlugNotFoundException
     */
    public function get(UuidInterface $id): ?Category;

    /**
     * @throws Throwable
     */
    public function create(Category $category): void;
}

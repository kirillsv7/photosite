<?php

namespace Source\Category\Application\Handlers;

use Source\Category\Application\Queries\CategoryGetQuery;
use Source\Category\Domain\Entities\Category;
use Source\Category\Domain\Exceptions\CategoryNotFoundException;
use Source\Category\Domain\Repositories\CategoryRepository;
use Source\MediaFile\Domain\Exceptions\MediaFileNotFoundException;
use Source\Shared\Handlers\Handler;
use Source\Slug\Domain\Exceptions\SlugNotFoundException;

final readonly class CategoryGetHandler extends Handler
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @throws CategoryNotFoundException
     * @throws MediaFileNotFoundException
     * @throws SlugNotFoundException
     */
    public function handle(CategoryGetQuery $query): Category
    {
        return $this->categoryRepository->get($query->id);
    }
}

<?php

namespace Source\Resource\Infrastructure\Factories;

use LogicException;
use Source\Category\Domain\Repositories\CategoryRepository;
use Source\Photo\Domain\Repositories\PhotoRepository;
use Source\Shared\Repositories\Contracts\ResourceRepository;
use Source\Slug\Domain\Enums\SluggableTypeEnum;

final readonly class RepositoryFactory
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected PhotoRepository $photoRepository
    ) {
    }

    /**
     * @throws LogicException
     */
    public function getRepository(SluggableTypeEnum $sluggableTypeEnum): ResourceRepository
    {
        return match ($sluggableTypeEnum) {
            SluggableTypeEnum::Category => $this->categoryRepository,
            SluggableTypeEnum::Photo => $this->photoRepository,
            default => throw new LogicException('Repository not implemented for the given type')
        };
    }
}

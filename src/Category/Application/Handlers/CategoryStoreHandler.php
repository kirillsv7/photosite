<?php

namespace Source\Category\Application\Handlers;

use Source\Category\Application\Commands\CategoryStoreCommand;
use Source\Category\Domain\Repositories\CategoryRepository;
use Source\Shared\Events\EventDispatcher;
use Source\Shared\Handlers\Handler;
use Throwable;

final readonly class CategoryStoreHandler extends Handler
{
    public function __construct(
        protected EventDispatcher $eventDispatcher,
        protected CategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(CategoryStoreCommand $command): void
    {
        $category = $command->category;

        $this->categoryRepository->create($category);

        $this->eventDispatcher->multiDispatch($category->releaseEvents());

        $this->eventDispatcher->multiDispatch($category->image?->releaseEvents());

        $this->eventDispatcher->multiDispatch($category->slug?->releaseEvents());
    }
}

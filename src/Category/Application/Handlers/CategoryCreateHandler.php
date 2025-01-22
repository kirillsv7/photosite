<?php

namespace Source\Category\Application\Handlers;

use Carbon\CarbonImmutable;
use Source\Category\Application\Commands\CategoryCreateCommand;
use Source\Category\Domain\Entities\Category;
use Source\Shared\Handlers\Handler;

final readonly class CategoryCreateHandler extends Handler
{
    public function handle(CategoryCreateCommand $command): Category
    {
        return Category::create(
            id: $command->id,
            title: $command->title,
            description: $command->description,
            image: $command->image,
            slug: $command->slug,
            createdAt: CarbonImmutable::now(),
        );
    }
}

<?php

namespace Source\Category\Application\Commands;

use Source\Category\Domain\Entities\Category;
use Source\Shared\Commands\Command;

final readonly class CategoryStoreCommand extends Command
{
    public function __construct(
        public Category $category,
    ) {
    }
}

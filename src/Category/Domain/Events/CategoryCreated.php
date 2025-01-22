<?php

namespace Source\Category\Domain\Events;

use Source\Category\Domain\Entities\Category;

final readonly class CategoryCreated
{
    public function __construct(
        public Category $category
    ) {
    }
}

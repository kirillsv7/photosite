<?php

namespace Source\Category\Domain\Events;

use Source\Category\Domain\Entities\Category;
use Source\Shared\Events\Event;

final readonly class CategoryCreatedEvent implements Event
{
    public function __construct(
        public Category $category
    ) {
    }
}

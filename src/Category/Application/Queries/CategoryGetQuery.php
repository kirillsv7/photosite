<?php

namespace Source\Category\Application\Queries;

use Ramsey\Uuid\UuidInterface;
use Source\Shared\Queries\Query;

final readonly class CategoryGetQuery extends Query
{
    public function __construct(
        public UuidInterface $id,
    ) {
    }
}

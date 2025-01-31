<?php

namespace Source\Photo\Application\Queries;

use Ramsey\Uuid\UuidInterface;
use Source\Shared\Queries\Query;

final readonly class PhotoGetQuery extends Query
{
    public function __construct(
        public UuidInterface $id,
    ) {
    }
}

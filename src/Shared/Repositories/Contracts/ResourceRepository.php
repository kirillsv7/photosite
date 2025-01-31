<?php

namespace Source\Shared\Repositories\Contracts;

use Ramsey\Uuid\UuidInterface;

interface ResourceRepository
{
    public function get(UuidInterface $id): mixed;
}

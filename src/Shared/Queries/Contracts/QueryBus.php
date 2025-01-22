<?php

namespace Source\Shared\Queries\Contracts;

use Source\Shared\Queries\Query;

interface QueryBus
{
    public function query(Query $query): mixed;

    public function map(array $map): void;
}

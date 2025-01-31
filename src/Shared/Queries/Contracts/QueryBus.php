<?php

namespace Source\Shared\Queries\Contracts;

use Source\Shared\Queries\Query;

interface QueryBus
{
    public function query(Query $query): mixed;

    /**
     * @param  array<string, string>  $map
     */
    public function map(array $map): void;
}

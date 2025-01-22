<?php

namespace Source\Shared\Queries;

use Illuminate\Bus\Dispatcher;
use Source\Shared\Queries\Contracts\QueryBus;

class LaravelQueryBus implements QueryBus
{
    public function __construct(
        protected Dispatcher $dispatcher
    ) {
    }

    public function query(Query $query): mixed
    {
        return $this->dispatcher->dispatch($query);
    }

    public function map(array $map): void
    {
        $this->dispatcher->map($map);
    }
}

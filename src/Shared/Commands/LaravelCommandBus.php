<?php

namespace Source\Shared\Commands;

use Illuminate\Bus\Dispatcher;
use Source\Shared\Commands\Contracts\CommandBus;

class LaravelCommandBus implements CommandBus
{
    public function __construct(
        protected Dispatcher $dispatcher
    ) {
    }

    public function run(Command $command): mixed
    {
        return $this->dispatcher->dispatch($command);
    }

    public function map(array $map): void
    {
        $this->dispatcher->map($map);
    }
}

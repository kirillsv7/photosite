<?php

namespace Source\Shared\Commands\Contracts;

use Source\Shared\Commands\Command;

interface CommandBus
{
    public function run(Command $command): mixed;

    public function map(array $map): void;
}

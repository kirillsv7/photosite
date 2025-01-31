<?php

namespace Source\Shared\Commands\Contracts;

use Source\Shared\Commands\Command;

interface CommandBus
{
    public function run(Command $command): mixed;

    /**
     * @param  array<string, string>  $map
     */
    public function map(array $map): void;
}

<?php

namespace Source\Shared\Entities\Contracts;

interface AggregateWithEvents
{
    public function releaseEvents(): array;
}

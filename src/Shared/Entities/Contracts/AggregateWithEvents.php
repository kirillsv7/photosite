<?php

namespace Source\Shared\Entities\Contracts;

use Source\Shared\Events\Event;

interface AggregateWithEvents
{
    /**
     * @return array<int, Event>
     */
    public function releaseEvents(): array;
}

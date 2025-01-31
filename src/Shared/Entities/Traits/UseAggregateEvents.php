<?php

namespace Source\Shared\Entities\Traits;

use Source\Shared\Events\Event;

trait UseAggregateEvents
{
    /**
     * @var array<int, Event>
     */
    private array $events = [];

    protected function addEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return array<int, Event>
     */
    public function releaseEvents(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }
}

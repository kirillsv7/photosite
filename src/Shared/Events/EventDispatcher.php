<?php

namespace Source\Shared\Events;

interface EventDispatcher
{
    /**
     * @param  array<int, Event>  $events
     */
    public function multiDispatch(array $events): void;
}

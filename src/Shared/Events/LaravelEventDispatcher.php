<?php

namespace Source\Shared\Events;

use Illuminate\Contracts\Events\Dispatcher;

final class LaravelEventDispatcher implements EventDispatcher
{
    public function __construct(
        public Dispatcher $dispatcher
    ) {
    }

    public function multiDispatch(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}

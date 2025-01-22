<?php

namespace Source\Shared\Events;

interface EventDispatcher
{
    public function multiDispatch(array $events): void;
}

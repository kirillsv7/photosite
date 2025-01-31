<?php

namespace Source\Photo\Infrastructure\EventListeners;

use Illuminate\Support\Facades\Log;
use Source\Photo\Domain\Events\PhotoCreatedEvent;

final readonly class PhotoCreatedEventListener
{
    public function handle(PhotoCreatedEvent $photoCreated): void
    {
        Log::info('New photo created', [
            'id' => $photoCreated->photo->id->toString(),
            'name' => $photoCreated->photo->title->toPrimitive(),
        ]);
    }
}

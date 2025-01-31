<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Source\MediaFile\Domain\Events\MediaFileCreatedEvent;
use Source\MediaFile\Infrastructure\EventListeners\ImageStoreExif;
use Source\MediaFile\Infrastructure\EventListeners\MediaFileGenerateThumbs;
use Source\Photo\Domain\Events\PhotoCreatedEvent;
use Source\Photo\Infrastructure\EventListeners\PhotoCreatedEventListener;
use Source\Shared\Events\EventDispatcher;
use Source\Shared\Events\LaravelEventDispatcher;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<array-key, string>
     */
    public $singletons = [
        EventDispatcher::class => LaravelEventDispatcher::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $eventWithListeners = [
            // CategoryCreated::class => CategoryCreatedEventListener::class,
            PhotoCreatedEvent::class => PhotoCreatedEventListener::class,
            MediaFileCreatedEvent::class => [
                MediaFileGenerateThumbs::class,
                ImageStoreExif::class,
            ],
        ];

        foreach ($eventWithListeners as $event => $listener) {
            if (is_array($listener)) {
                foreach ($listener as $listenerClass) {
                    Event::listen($event, $listenerClass);
                }

                continue;
            }

            Event::listen($event, $listener);
        }
    }
}

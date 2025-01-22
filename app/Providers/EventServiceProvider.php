<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Source\Category\Domain\Events\CategoryCreated;
use Source\MediaFile\Domain\Events\MediaFileCreated;
use Source\MediaFile\Infrastructure\EventListeners\ImageStoreExif;
use Source\MediaFile\Infrastructure\EventListeners\MediaFileGenerateThumbs;
use Source\Photo\Domain\Events\PhotoCreated;
use Source\Photo\Infrastructure\EventListeners\PhotoCreatedEventListener;
use Source\Shared\Events\EventDispatcher;
use Source\Shared\Events\LaravelEventDispatcher;

class EventServiceProvider extends ServiceProvider
{
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
            //CategoryCreated::class => CategoryCreatedEventListener::class,
            PhotoCreated::class => PhotoCreatedEventListener::class,
            MediaFileCreated::class => [
                MediaFileGenerateThumbs::class,
                ImageStoreExif::class,
            ],
        ];

        foreach ($eventWithListeners as $event => $listener) {
            if(is_array($listener)) {
                foreach ($listener as $listenerClass) {
                    Event::listen($event, $listenerClass);
                }

                continue;
            }

            Event::listen($event, $listener);
        }
    }
}

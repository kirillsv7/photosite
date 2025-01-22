<?php

namespace Source\Photo\Application\Handlers;

use Source\Photo\Application\Commands\PhotoStoreCommand;
use Source\Photo\Domain\Repositories\PhotoRepository;
use Source\Shared\Events\EventDispatcher;
use Source\Shared\Handlers\Handler;
use Throwable;

final readonly class PhotoStoreHandler extends Handler
{
    public function __construct(
        protected EventDispatcher $eventDispatcher,
        protected PhotoRepository $photoRepository,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(PhotoStoreCommand $command): void
    {
        $photo = $command->photo;

        $this->photoRepository->create($photo);

        $this->eventDispatcher->multiDispatch($photo->releaseEvents());

        $this->eventDispatcher->multiDispatch($photo->image->releaseEvents());

        $this->eventDispatcher->multiDispatch($photo->slug->releaseEvents());
    }
}

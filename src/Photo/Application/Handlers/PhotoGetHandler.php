<?php

namespace Source\Photo\Application\Handlers;

use Source\MediaFile\Domain\Exceptions\MediaFileNotFoundException;
use Source\Photo\Application\Queries\PhotoGetQuery;
use Source\Photo\Domain\Entities\Photo;
use Source\Photo\Domain\Exceptions\PhotoNotFoundException;
use Source\Photo\Domain\Repositories\PhotoRepository;
use Source\Shared\Handlers\Handler;
use Source\Slug\Domain\Exceptions\SlugNotFoundException;

final readonly class PhotoGetHandler extends Handler
{
    public function __construct(
        protected PhotoRepository $photoRepository,
    ) {
    }

    /**
     * @throws PhotoNotFoundException
     * @throws MediaFileNotFoundException
     * @throws SlugNotFoundException
     */
    public function handle(PhotoGetQuery $query): ?Photo
    {
        return $this->photoRepository->get($query->id);
    }
}

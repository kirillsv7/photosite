<?php

namespace Source\Photo\Domain\Repositories;

use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Exceptions\MediaFileNotFoundException;
use Source\Photo\Domain\Entities\Photo;
use Source\Photo\Domain\Exceptions\PhotoNotFoundException;
use Source\Shared\Repositories\Contracts\ResourceRepository;
use Source\Slug\Domain\Exceptions\SlugNotFoundException;
use Throwable;

interface PhotoRepository extends ResourceRepository
{
    /**
     * @throws PhotoNotFoundException
     * @throws MediaFileNotFoundException
     * @throws SlugNotFoundException
     */
    public function get(UuidInterface $id): Photo;

    /**
     * @throws Throwable
     */
    public function create(Photo $photo): void;
}

<?php

namespace Source\MediaFile\Domain\Repositories;

use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Exceptions\MediaFileNotFoundException;
use Source\Shared\Repositories\Contracts\Repository;
use Throwable;

interface MediaFileRepository extends Repository
{
    /**
     * @throws MediaFileNotFoundException
     */
    public function get(UuidInterface $id): ?MediaFile;

    /**
     * @throws Throwable
     */
    public function create(MediaFile $mediaFile): void;

    /**
     * @throws MediaFileNotFoundException
     * @throws Throwable
     */
    public function update(MediaFile $mediaFile): void;

    /**
     * @throws MediaFileNotFoundException
     */
    public function getById(UuidInterface $id): ?MediaFile;

    /**
     * @throws MediaFileNotFoundException
     */
    public function getByMediableId(UuidInterface $mediableId): ?MediaFile;
}

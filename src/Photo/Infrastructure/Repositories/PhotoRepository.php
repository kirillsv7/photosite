<?php

namespace Source\Photo\Infrastructure\Repositories;

use Carbon\CarbonImmutable;
use Illuminate\Database\ConnectionInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Repositories\MediaFileRepository;
use Source\Photo\Domain\Entities\Photo;
use Source\Photo\Domain\Exceptions\PhotoNotFoundException;
use Source\Photo\Domain\Repositories\PhotoRepository as PhotoRepositoryContract;
use Source\Photo\Infrastructure\Models\PhotoModel;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Entities\Slug;
use Source\Slug\Domain\Repositories\SlugRepository;

final readonly class PhotoRepository implements PhotoRepositoryContract
{
    public function __construct(
        protected ConnectionInterface $connection,
        protected MediaFileRepository $mediaFileRepository,
        protected SlugRepository $slugRepository,
    ) {
    }

    public function get(UuidInterface $id): Photo
    {
        $photoModel = PhotoModel::query()
            ->where('id', $id->toString())
            ->first();

        if (! $photoModel) {
            throw new PhotoNotFoundException();
        }

        $uuid = Uuid::fromString($photoModel->getAttribute('id'));

        $mediaFile = $this->mediaFileRepository
            ->getByMediableId($uuid);

        $slug = $this->slugRepository->getBySluggableId($uuid);

        return $this->map($photoModel, $mediaFile, $slug);
    }

    public function create(Photo $photo): void
    {
        $this->connection->transaction(function () use ($photo) {
            $model = new PhotoModel();

            $model->setAttribute('id', $photo->id->toString());
            $model->setAttribute('title', $photo->title->toPrimitive());
            $model->setAttribute('created_at', CarbonImmutable::now());

            $model->save();

            $this->mediaFileRepository->create($photo->image);

            $this->slugRepository->create($photo->slug);
        });
    }

    private function map(
        PhotoModel $model,
        MediaFile $mediaFile,
        Slug $slug,
    ): Photo {
        return Photo::make(
            id: Uuid::fromString($model->getAttribute('id')),
            title: StringValueObject::fromString($model->getAttribute('title')),
            image: $mediaFile,
            slug: $slug,
            createdAt: $model->getAttribute('created_at'),
            updatedAt: $model->getAttribute('updated_at'),
        );
    }
}

<?php

namespace Source\Photo\Interface\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Ramsey\Uuid\Uuid;
use Source\MediaFile\Application\Commands\MediaFileCreateCommand;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Enums\MediableTypeEnum;
use Source\Photo\Application\Commands\PhotoCreateCommand;
use Source\Photo\Application\Commands\PhotoStoreCommand;
use Source\Photo\Application\Queries\PhotoGetQuery;
use Source\Photo\Domain\Entities\Photo;
use Source\Photo\Interface\Requests\PhotoStoreRequest;
use Source\Shared\Commands\Contracts\CommandBus;
use Source\Shared\Queries\Contracts\QueryBus;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Application\Commands\SlugCreateCommand;
use Source\Slug\Domain\Entities\Slug;
use Source\Slug\Domain\Enums\SluggableTypeEnum;

final readonly class PhotoController
{
    public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus,
    ) {
    }

    public function get(string $id): JsonResponse
    {
        $photoGetQuery = new PhotoGetQuery(Uuid::fromString($id));

        /** @var Photo $photo */
        $photo = $this->queryBus->query($photoGetQuery);

        return Response::json(
            $photo->toArray(),
        );
    }

    public function store(PhotoStoreRequest $request): JsonResponse
    {
        $requestDTO = $request->getDTO();

        $photoId = Uuid::uuid6();

        $imageFile = $requestDTO->image;

        $mediaFileCreateCommand = new MediaFileCreateCommand(
            file: $imageFile,
            mediableId: $photoId,
            mediableTypeEnum: MediableTypeEnum::Photo,
            mediableFolder: Photo::getMediableFolder(),
        );

        /** @var MediaFile $image */
        $image = $this->commandBus->run($mediaFileCreateCommand);

        $originalFileNameWithoutExtension = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

        $title = StringValueObject::fromString($requestDTO->title ?? $originalFileNameWithoutExtension);

        $slugCreateCommand = new SlugCreateCommand(
            title: $title,
            sluggableId: $photoId,
            sluggableTypeEnum: SluggableTypeEnum::Photo,
            slugBase: Photo::getSlugBase(),
        );

        /** @var Slug $slug */
        $slug = $this->commandBus->run($slugCreateCommand);

        $photoCreateCommand = new PhotoCreateCommand(
            id: $photoId,
            title: $title,
            image: $image,
            slug: $slug,
        );

        /** @var Photo $photo */
        $photo = $this->commandBus->run($photoCreateCommand);

        $photoStoreCommand = new PhotoStoreCommand($photo);

        $this->commandBus->run($photoStoreCommand);

        return Response::json(
            $photo->toArray(),
            JsonResponse::HTTP_CREATED
        );
    }
}

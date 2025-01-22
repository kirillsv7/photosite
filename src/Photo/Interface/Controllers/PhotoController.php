<?php

namespace Source\Photo\Interface\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Ramsey\Uuid\Uuid;
use Source\MediaFile\Application\Commands\MediaFileCreateCommand;
use Source\MediaFile\Domain\Enums\MediableTypeEnum;
use Source\Photo\Application\Commands\PhotoCreateCommand;
use Source\Photo\Application\Commands\PhotoStoreCommand;
use Source\Photo\Domain\Entities\Photo;
use Source\Photo\Interface\Requests\PhotoStoreRequest;
use Source\Shared\Commands\Contracts\CommandBus;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Application\Commands\SlugCreateCommand;
use Source\Slug\Domain\Enums\SluggableTypeEnum;

final readonly class PhotoController
{
    public function __construct(
        protected CommandBus $commandBus,
    ) {
    }

    public function get(string $id): string
    {
        return $id;
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

        $image = $this->commandBus->run($mediaFileCreateCommand);

        $originalFileNameWithoutExtension = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

        $title = StringValueObject::fromString($requestDTO->title ?? $originalFileNameWithoutExtension);

        $slugCreateCommand = new SlugCreateCommand(
            title: $title,
            sluggableId: $photoId,
            sluggableTypeEnum: SluggableTypeEnum::Photo,
            slugBase: Photo::getSlugBase(),
        );

        $slug = $this->commandBus->run($slugCreateCommand);

        $photoCreateCommand = new PhotoCreateCommand(
            id: $photoId,
            title: $title,
            image: $image,
            slug: $slug,
        );

        $photo = $this->commandBus->run($photoCreateCommand);

        $photoStoreCommand = new PhotoStoreCommand($photo);

        $this->commandBus->run($photoStoreCommand);

        return Response::json(
            $photo->toArray(),
            JsonResponse::HTTP_CREATED
        );
    }
}

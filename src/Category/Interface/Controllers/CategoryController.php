<?php

namespace Source\Category\Interface\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Ramsey\Uuid\Uuid;
use Source\Category\Application\Commands\CategoryCreateCommand;
use Source\Category\Application\Commands\CategoryStoreCommand;
use Source\Category\Application\Queries\CategoryGetQuery;
use Source\Category\Domain\Entities\Category;
use Source\Category\Interface\Requests\CategoryStoreRequest;
use Source\MediaFile\Application\Commands\MediaFileCreateCommand;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Enums\MediableTypeEnum;
use Source\Shared\Commands\Contracts\CommandBus;
use Source\Shared\Queries\Contracts\QueryBus;
use Source\Slug\Application\Commands\SlugCreateCommand;
use Source\Slug\Domain\Entities\Slug;
use Source\Slug\Domain\Enums\SluggableTypeEnum;

final readonly class CategoryController
{
    public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus,
    ) {
    }

    public function get(string $id): JsonResponse
    {
        $categoryGetQuery = new CategoryGetQuery(Uuid::fromString($id));

        /** @var Category $category */
        $category = $this->queryBus->query($categoryGetQuery);

        return Response::json([
            'category' => $category->toArray(),
        ]);
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $requestDTO = $request->getDTO();

        $categoryId = Uuid::uuid6();

        $imageFile = $requestDTO->image;

        $image = null;

        if ($imageFile) {
            $mediaFileCreateCommand = new MediaFileCreateCommand(
                file: $imageFile,
                mediableId: $categoryId,
                mediableTypeEnum: MediableTypeEnum::Category,
                mediableFolder: Category::getMediableFolder(),
            );

            /** @var MediaFile $image */
            $image = $this->commandBus->run($mediaFileCreateCommand);
        }

        $slugCreateCommand = new SlugCreateCommand(
            title: $requestDTO->title,
            sluggableId: $categoryId,
            sluggableTypeEnum: SluggableTypeEnum::Category,
            slugBase: Category::getSlugBase(),
        );

        /** @var Slug $slug */
        $slug = $this->commandBus->run($slugCreateCommand);

        $categoryCreateCommand = new CategoryCreateCommand(
            id: $categoryId,
            title: $requestDTO->title,
            description: $requestDTO->description,
            image: $image,
            slug: $slug,
        );

        /** @var Category $category */
        $category = $this->commandBus->run($categoryCreateCommand);

        $categoryStoreCommand = new CategoryStoreCommand($category);

        $this->commandBus->run($categoryStoreCommand);

        return Response::json(
            $category->toArray(),
            JsonResponse::HTTP_CREATED
        );
    }
}

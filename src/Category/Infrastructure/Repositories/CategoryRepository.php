<?php

namespace Source\Category\Infrastructure\Repositories;

use Carbon\CarbonImmutable;
use Illuminate\Database\ConnectionInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Source\Category\Domain\Entities\Category;
use Source\Category\Domain\Exceptions\CategoryNotFoundException;
use Source\Category\Domain\Repositories\CategoryRepository as CategoryRepositoryContract;
use Source\Category\Infrastructure\Models\CategoryModel;
use Source\MediaFile\Domain\Entities\MediaFile;
use Source\MediaFile\Domain\Repositories\MediaFileRepository;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Entities\Slug;
use Source\Slug\Domain\Repositories\SlugRepository;

final readonly class CategoryRepository implements CategoryRepositoryContract
{
    public function __construct(
        protected ConnectionInterface $connection,
        protected MediaFileRepository $mediaFileRepository,
        protected SlugRepository $slugRepository,
    ) {
    }

    public function get(UuidInterface $id): Category
    {
        $categoryModel = CategoryModel::query()
            ->where('id', $id->toString())
            ->first();

        if (!$categoryModel) {
            throw new CategoryNotFoundException();
        }

        $uuid = Uuid::fromString($categoryModel->id);

        $mediaFile = $this->mediaFileRepository
            ->getByMediableId($uuid);

        $slug = $this->slugRepository->getBySluggableId($uuid);

        return $this->map($categoryModel, $mediaFile, $slug);
    }

    public function create(Category $category): void
    {
        $this->connection->transaction(function () use ($category) {
            $model = new CategoryModel();

            $model->setAttribute('id', $category->id->toString());
            $model->setAttribute('title', $category->title->toPrimitive());
            $model->setAttribute('description', $category->description?->toPrimitive());
            $model->setAttribute('created_at', CarbonImmutable::now());

            $model->save();

            if ($category->image) {
                $this->mediaFileRepository->create($category->image);
            }

            $this->slugRepository->create($category->slug);
        });
    }

    private function map(
        CategoryModel $model,
        ?MediaFile $mediaFile,
        Slug $slug,
    ): Category {
        return Category::make(
            id: Uuid::fromString($model->id),
            title: StringValueObject::fromString($model->title),
            description: $model->description
                ? StringValueObject::fromString($model->description)
                : null,
            image: $mediaFile,
            slug: $slug,
            createdAt: $model->created_at,
            updatedAt: $model->updated_at,
        );
    }
}

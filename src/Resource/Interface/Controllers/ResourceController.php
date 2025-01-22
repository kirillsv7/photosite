<?php

namespace Source\Resource\Interface\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Source\Resource\Infrastructure\Factories\RepositoryFactory;
use Source\Shared\Exceptions\NotFoundException;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Exceptions\SlugNotFoundException;
use Source\Slug\Domain\Repositories\SlugRepository;

class ResourceController
{
    public function __construct(
        protected SlugRepository $slugRepository,
        protected RepositoryFactory $repositoryFactory,
    ) {
    }

    public function getBySlug(string $slug): JsonResponse
    {
        try {
            $sluggableDomain = $this->slugRepository
                ->getBySlug(StringValueObject::fromString($slug));

            $repository = $this->repositoryFactory
                ->getRepository($sluggableDomain->sluggableType);

            $resource = $repository->get($sluggableDomain->sluggableId);
        } catch (SlugNotFoundException|NotFoundException $e) {
            return Response::json(
                ['message' => 'Resource not found'],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        return Response::json($resource->toArray());
    }
}

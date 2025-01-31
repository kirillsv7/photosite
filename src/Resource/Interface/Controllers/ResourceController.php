<?php

namespace Source\Resource\Interface\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use LogicException;
use Source\Category\Domain\Exceptions\CategoryNotFoundException;
use Source\MediaFile\Domain\Exceptions\MediaFileNotFoundException;
use Source\Photo\Domain\Exceptions\PhotoNotFoundException;
use Source\Resource\Infrastructure\Factories\InertiaRenderFactory;
use Source\Resource\Infrastructure\Factories\RepositoryFactory;
use Source\Shared\Entities\Contracts\Entity;
use Source\Shared\ValueObjects\StringValueObject;
use Source\Slug\Domain\Contracts\Sluggable;
use Source\Slug\Domain\Exceptions\SlugNotFoundException;
use Source\Slug\Domain\Repositories\SlugRepository;

class ResourceController
{
    public function __construct(
        protected SlugRepository $slugRepository,
        protected RepositoryFactory $repositoryFactory,
        protected InertiaRenderFactory $inertiaRenderFactory,
    ) {
    }

    public function getBySlug(string $slug): InertiaResponse|JsonResponse
    {
        try {
            $slugDomain = $this->slugRepository
                ->getBySlug(StringValueObject::fromString($slug));

            $repository = $this->repositoryFactory
                ->getRepository($slugDomain->sluggableType);

            /** @var Entity & Sluggable $resource */
            $resource = $repository->get($slugDomain->sluggableId);
        } catch (
            SlugNotFoundException
            |CategoryNotFoundException
            |PhotoNotFoundException
            |MediaFileNotFoundException
            $e
        ) {
            Log::error($e->getMessage(), ['slug' => $slug]);

            return Response::json(
                ['message' => 'Resource not found'],
                JsonResponse::HTTP_NOT_FOUND
            );
        } catch (LogicException $e) {
            return Response::json(
                ['message' => 'Repository not found'],
                JsonResponse::HTTP_SERVICE_UNAVAILABLE
            );
        }

        try {
            $renderDTO = $this->inertiaRenderFactory->getRender($slugDomain);
        } catch (LogicException $e) {
            return Response::json(
                ['message' => 'Render not found'],
                JsonResponse::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return Inertia::render($renderDTO->render, [
            $renderDTO->resource => $resource->toArray(),
        ]);
    }
}

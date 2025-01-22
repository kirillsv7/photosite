<?php

namespace Source\Slug\Application\Handlers;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\Uuid;
use Source\Shared\Handlers\Handler;
use Source\Slug\Application\Commands\SlugCreateCommand;
use Source\Slug\Domain\Entities\Slug;
use Source\Slug\Domain\ValueObjects\SlugString;
use Source\Slug\Infrastructure\Services\SlugGenerator;

final readonly class SlugCreateHandler extends Handler
{
    public function __construct(
        protected SlugGenerator $slugGenerator,
    ) {
    }

    public function handle(SlugCreateCommand $command): Slug
    {
        $slugString = SlugString::fromFragments([
            $command->slugBase,
            $command->title,
        ]);

        $uniqueSlugString = $this->slugGenerator->generateUniqueSlug($slugString);

        return Slug::create(
            id: Uuid::uuid6(),
            value: $uniqueSlugString,
            sluggableType: $command->sluggableTypeEnum,
            sluggableId: $command->sluggableId,
            createdAt: CarbonImmutable::now(),
        );
    }
}

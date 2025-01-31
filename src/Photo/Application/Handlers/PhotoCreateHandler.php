<?php

namespace Source\Photo\Application\Handlers;

use Carbon\CarbonImmutable;
use Source\Photo\Application\Commands\PhotoCreateCommand;
use Source\Photo\Domain\Entities\Photo;
use Source\Shared\Handlers\Handler;

final readonly class PhotoCreateHandler extends Handler
{
    public function handle(PhotoCreateCommand $command): Photo
    {
        return Photo::create(
            id: $command->id,
            title: $command->title,
            image: $command->image,
            slug: $command->slug,
            createdAt: CarbonImmutable::now(),
        );
    }
}

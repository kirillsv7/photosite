<?php

namespace Source\Resource\Infrastructure\Factories;

use LogicException;
use Source\Resource\Infrastructure\DTOs\RenderDTO;
use Source\Slug\Domain\Entities\Slug;
use Source\Slug\Domain\Enums\SluggableTypeEnum;

class InertiaRenderFactory
{
    /**
     * @throws LogicException
     */
    public function getRender(Slug $slug): RenderDTO
    {
        return match ($slug->sluggableType) {
            SluggableTypeEnum::Category => new RenderDTO('Category/Show', 'category'),
            SluggableTypeEnum::Photo => new RenderDTO('Photo/Show', 'photo'),
            default => throw new LogicException('Render not implemented for the given type')
        };
    }
}

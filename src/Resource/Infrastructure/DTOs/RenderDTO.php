<?php

namespace Source\Resource\Infrastructure\DTOs;

final readonly class RenderDTO
{
    public function __construct(
        public string $render,
        public string $resource,
    ) {
    }
}

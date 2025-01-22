<?php

namespace Source\Slug\Domain\Events;

final readonly class SlugCreated
{
    public function __construct(
        private int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}

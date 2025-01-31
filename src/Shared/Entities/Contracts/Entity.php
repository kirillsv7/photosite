<?php

namespace Source\Shared\Entities\Contracts;

interface Entity
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}

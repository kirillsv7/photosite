<?php

namespace Source\Shared\Enums\Traits;

trait UseNonBackedEnumSerializableTrait
{
    public function jsonSerialize(): string
    {
        return $this->name;
    }
}

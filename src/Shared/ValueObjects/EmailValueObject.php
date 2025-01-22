<?php

namespace Source\Shared\ValueObjects;

final readonly class EmailValueObject extends StringValueObject
{
    protected function __construct(string $value)
    {
        parent::__construct($value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email');
        }
    }
}

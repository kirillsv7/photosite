<?php

namespace Source\Shared\ValueObjects;

/** @phpstan-consistent-constructor */
readonly class StringValueObject
{
    protected function __construct(
        private string $value
    ) {
        if ($this->empty()) {
            throw new \InvalidArgumentException(sprintf('%s must have value', get_class($this)));
        }
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    /** @param  array<string>  $values */
    public static function fromArray(string $separator, array $values): static
    {
        return new static(implode($separator, $values));
    }

    public function append(string $value): static
    {
        return new static($this->value.$value);
    }

    public function equals(StringValueObject $otherString): bool
    {
        return $this->value === $otherString->value;
    }

    public function empty(): bool
    {
        return empty($this->value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function toPrimitive(): string
    {
        return $this->value;
    }
}

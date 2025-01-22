<?php

namespace Source\Slug\Domain\Contracts;

use Source\Shared\ValueObjects\StringValueObject;

interface Sluggable
{
    public static function getSlugBase(): StringValueObject;
}

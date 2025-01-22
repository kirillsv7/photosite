<?php

namespace Source\MediaFile\Domain\Contracts;

use Source\Shared\ValueObjects\StringValueObject;

interface Mediable
{
    public static function getMediableFolder(): StringValueObject;
}

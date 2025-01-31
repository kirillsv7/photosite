<?php

namespace Source\Photo\Domain\Exceptions;

use Illuminate\Http\JsonResponse;
use Source\Shared\Exceptions\DefaultException;

class PhotoNotFoundException extends DefaultException
{
    /** @phpstan-ignore missingType.property */
    protected $code = JsonResponse::HTTP_NOT_FOUND;

    /** @phpstan-ignore missingType.property */
    protected $message = 'Photo doesn\'t exists';
}

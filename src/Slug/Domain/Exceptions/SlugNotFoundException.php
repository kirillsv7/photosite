<?php

namespace Source\Slug\Domain\Exceptions;

use Illuminate\Http\JsonResponse;
use Source\Shared\Exceptions\DefaultException;

class SlugNotFoundException extends DefaultException
{
    /** @phpstan-ignore missingType.property */
    protected $code = JsonResponse::HTTP_NOT_FOUND;

    /** @phpstan-ignore missingType.property */
    protected $message = 'Slug doesn\'t exists';
}

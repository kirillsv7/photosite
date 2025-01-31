<?php

namespace Source\Shared\Exceptions;

use Illuminate\Http\JsonResponse;

class NotFoundException extends DefaultException
{
    /** @phpstan-ignore missingType.property */
    protected $code = JsonResponse::HTTP_NOT_FOUND;

    /** @phpstan-ignore missingType.property */
    protected $message = 'Page doesn\'t exists';
}

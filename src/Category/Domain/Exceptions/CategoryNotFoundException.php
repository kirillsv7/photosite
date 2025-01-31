<?php

namespace Source\Category\Domain\Exceptions;

use Illuminate\Http\JsonResponse;
use Source\Shared\Exceptions\DefaultException;

class CategoryNotFoundException extends DefaultException
{
    /** @phpstan-ignore missingType.property */
    protected $code = JsonResponse::HTTP_NOT_FOUND;

    /** @phpstan-ignore missingType.property */
    protected $message = 'Category doesn\'t exists';
}

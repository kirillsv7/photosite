<?php

namespace Source\MediaFile\Domain\Exceptions;

use Illuminate\Http\JsonResponse;
use Source\Shared\Exceptions\DefaultException;

class MediaFileNotFoundException extends DefaultException
{
    /** @phpstan-ignore missingType.property */
    protected $code = JsonResponse::HTTP_NOT_FOUND;

    /** @phpstan-ignore missingType.property */
    protected $message = 'MediaFile doesn\'t exists';
}

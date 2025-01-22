<?php

namespace Source\MediaFile\Domain\Exceptions;

use Illuminate\Http\JsonResponse;
use Source\Shared\Exceptions\DefaultException;

class MediaFileNotFoundException extends DefaultException
{
    protected $code = JsonResponse::HTTP_NOT_FOUND;
    protected $message = 'MediaFile doesn\'t exists';
}

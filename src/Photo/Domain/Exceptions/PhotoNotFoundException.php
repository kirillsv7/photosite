<?php

namespace Source\Photo\Domain\Exceptions;

use Illuminate\Http\JsonResponse;
use Source\Shared\Exceptions\DefaultException;

class PhotoNotFoundException extends DefaultException
{
    protected $code = JsonResponse::HTTP_NOT_FOUND;

    protected $message = 'Photo doesn\'t exists';
}

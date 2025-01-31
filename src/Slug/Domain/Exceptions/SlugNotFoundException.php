<?php

namespace Source\Slug\Domain\Exceptions;

use Illuminate\Http\JsonResponse;
use Source\Shared\Exceptions\DefaultException;

class SlugNotFoundException extends DefaultException
{
    protected $code = JsonResponse::HTTP_NOT_FOUND;

    protected $message = 'Slug doesn\'t exists';
}

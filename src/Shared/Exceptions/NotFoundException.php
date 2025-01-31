<?php

namespace Source\Shared\Exceptions;

use Illuminate\Http\JsonResponse;

class NotFoundException extends DefaultException
{
    protected $code = JsonResponse::HTTP_NOT_FOUND;

    protected $message = 'Page doesn\'t exists';
}

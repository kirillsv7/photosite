<?php

namespace Source\Category\Domain\Exceptions;

use Illuminate\Http\JsonResponse;
use Source\Shared\Exceptions\DefaultException;

class CategoryNotFoundException extends DefaultException
{
    protected $code = JsonResponse::HTTP_NOT_FOUND;
    protected $message = 'Category doesn\'t exists';
}

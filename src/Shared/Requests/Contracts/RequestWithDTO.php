<?php

namespace Source\Shared\Requests\Contracts;

interface RequestWithDTO
{
    public function getDTO(): mixed;
}

<?php

namespace AmoPRO\AmoCRM\Exceptions\Http;

use RuntimeException;

class UnauthorizedException extends RuntimeException
{
    public function __construct($message = "")
    {
        parent::__construct($message, 401, null);
    }
}
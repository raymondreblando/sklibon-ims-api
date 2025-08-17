<?php

namespace App\Exceptions;

use Exception;

class InvalidRefreshTokenException extends Exception
{
    public function __construct(string $message = 'Refresh token expired', int $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

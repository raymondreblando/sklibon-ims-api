<?php

namespace App\Exceptions;

use Exception;

class InvalidUserCredentialsException extends Exception
{
    public function __construct(
        string $message = 'Unable to sign in with the provided credentials.',
        int $code = 401,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

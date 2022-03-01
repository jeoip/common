<?php

namespace Jeoip\Common\Exceptions;

use Jeoip\Contracts\Exceptions\IPrivateClassException;
use Throwable;

class PrivateClassException extends QueryException implements IPrivateClassException
{
    public function __construct(string $query, string $message = 'This a private class of IP', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $query, $code, $previous);
    }
}

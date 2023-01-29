<?php

namespace Jeoip\Common\Exceptions;

use Jeoip\Contracts\Exceptions\IUnknownLocationException;

class UnknownLocationException extends QueryException implements IUnknownLocationException
{
    public function __construct(string $query, string $message = 'Cannot find location for this query', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $query, $code, $previous);
    }
}

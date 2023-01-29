<?php

namespace Jeoip\Common\Exceptions;

use Jeoip\Contracts\Exceptions\IQueryException;

class QueryException extends Exception implements IQueryException
{
    protected string $query;

    public function __construct(string $message, string $query, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->query = $query;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}

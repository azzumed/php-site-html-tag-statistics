<?php

namespace Parser\Exceptions;

use Exception;
use Throwable;

class CantResolveContentException extends Exception
{
    protected string $path;

    public function __construct(string $path, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->path = $path;

        parent::__construct($message, $code, $previous);
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
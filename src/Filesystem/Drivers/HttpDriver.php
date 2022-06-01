<?php

namespace Parser\Filesystem\Drivers;

use Parser\Contracts\FilesystemDriver;
use Parser\Exceptions\CantResolveContentException;
use Parser\Http\Http;

class HttpDriver implements FilesystemDriver
{
    protected Http $http;

    public function __construct(string $root)
    {
        $this->http = new Http($root);
    }

    public function read($filename): string
    {
        $response = $this->http->requestGet($filename);

        if ($response->isOk() === false) {
            throw new CantResolveContentException($this->http->getUrl());
        }

        return $response->getContent();
    }
}
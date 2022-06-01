<?php

namespace Parser\Filesystem;

use Parser\Contracts\FilesystemDriver;

class FilesystemAdapter
{
    protected FilesystemDriver $driver;

    public function __construct(FilesystemDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param $filename
     * @return Content
     * @throws \Parser\Exceptions\CantResolveContentException
     */
    public function read($filename): Content
    {
        return new Content($this->driver->read($filename));
    }

    public function __call($method, array $parameters)
    {
        return $this->driver->{$method}(...$parameters);
    }
}
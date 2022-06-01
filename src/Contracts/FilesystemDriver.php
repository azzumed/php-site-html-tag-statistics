<?php

namespace Parser\Contracts;

use Parser\Exceptions\CantResolveContentException;

interface FilesystemDriver
{
    /**
     * @param $filename
     * @return string
     * @throws CantResolveContentException
     */
    public function read($filename): string;
}
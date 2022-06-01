<?php

namespace Parser\Filesystem\Drivers;

use Parser\Contracts\FilesystemDriver;
use Parser\Exceptions\CantResolveContentException;

class LocalDriver implements FilesystemDriver
{
    protected string $root;

    public function __construct(string $root)
    {
        $this->root = realpath($root);
    }

    public function read($filename): string
    {
        $path = $this->root . '/' . $filename;

        if (!file_exists($path) || is_dir($filename)) {
            throw new CantResolveContentException($path, 'File not found');
        }

        $content = file_get_contents($path);

        if (!is_string($content)) {
            throw new CantResolveContentException($path, 'Cannot read content');
        }

        return $content;
    }
}
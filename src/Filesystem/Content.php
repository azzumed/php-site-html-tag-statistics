<?php

namespace Parser\Filesystem;

class Content
{
    protected string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function get(): string
    {
        return $this->content;
    }
}
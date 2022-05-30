<?php

namespace Parser\Http;

class Response
{
    /**
     * @var mixed
     */
    protected $content;

    protected int $httpCode;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setHttpCode(int $code)
    {
        $this->httpCode = $code;
    }

    public function isOk(): bool
    {
        return $this->httpCode >= 200 && $this->httpCode <= 299;
    }

    public function getHttpCode()
    {
        return $this->content;
    }
}
<?php

namespace Parser\Http;

class Http
{
    protected string $base;

    /**
     * @var resource
     */
    protected $connection;

    protected ?string $url = null;

    public function __construct(string $base)
    {
        $this->base = rtrim($base, '/');
    }

    public function requestGet($path, array $query = [])
    {
        $this->prepareForRequest($path, $query);

        return $this->executeRequest();
    }

    protected function prepareForRequest($path, $query)
    {
        $url = $this->buildUrl($path) . '?' . http_build_query($query);

        $this->ensureOpenedConnection();
        $this->setRequestUrl($url);
    }

    protected function setRequestUrl($url)
    {
        $this->url = $url;
        curl_setopt($this->connection, CURLOPT_URL, $url);
    }

    protected function executeRequest()
    {
        $content = curl_exec($this->connection);
        $response = new Response($content);
        $response->setHttpCode(
            curl_getinfo($this->connection, CURLINFO_HTTP_CODE)
        );

        return $response;
    }

    protected function ensureOpenedConnection()
    {
        if (isset($this->connection)) {
            return;
        }

        $this->connection = curl_init();
        curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, true);
    }

    protected function buildUrl($path): string
    {
        return $this->base . '/' . $path;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function __destruct()
    {
        if (isset($this->connection)) {
            curl_close($this->connection);
        }
    }
}
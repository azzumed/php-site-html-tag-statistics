<?php

namespace Parser\Website;

use Parser\Http\Http;

class Website
{
    protected Http $http;

    public function __construct($host)
    {
        $this->http = new Http($host);
    }

    public function getTagStatistics($path)
    {
        $response = $this->http->requestGet($path);

        if (!$response->isOk()) {
            return false;
        }

        preg_match_all('/<([A-Za-z-]+?)(?:\s.*)?>/', $response->getContent(), $matches, PREG_SET_ORDER);

        $result = [];

        foreach ($matches as [$content, $tag]) {
            $result[$tag] ??= [
                'tag' => $tag,
                'count' => 0
            ];

            $result[$tag]['count']++;
        }

        usort($result, function($a, $b) {
            return $b['count'] - $a['count'];
        });

        return $result;
    }
}
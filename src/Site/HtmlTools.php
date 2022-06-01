<?php

namespace Parser\Site;

use Parser\Filesystem\Content;
use Parser\Filesystem\FilesystemAdapter;

class HtmlTools
{
    protected Content $content;

    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    public function getTagStatistics(): array
    {
        preg_match_all('/<([A-Za-z\d-]+?)(?:\s.*)?>/', $this->content->get(), $matches, PREG_SET_ORDER);

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
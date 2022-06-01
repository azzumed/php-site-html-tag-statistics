<?php

namespace Parser\Site;

use Parser\Filesystem\FilesystemAdapter;

class HtmlTools
{
    protected FilesystemAdapter $adapter;

    public function __construct(FilesystemAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @throws \Parser\Exceptions\CantResolveContentException
     */
    public function getTagStatistics(string $filename): array
    {
        $content = $this->adapter->read($filename);

        preg_match_all('/<([A-Za-z\d-]+?)(?:\s.*)?>/', $content->get(), $matches, PREG_SET_ORDER);

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
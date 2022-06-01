<?php

use Parser\Filesystem\Drivers\LocalDriver;

function app_path(string $append = null): string
{
    $path = __DIR__ . '/../../';

    if (isset($append)) {
        $path .= $append;
    }

    return realpath(rtrim($path, '/'));
}

function config(): array
{
    return [
        'filesystems' => [
            'default' => 'pages',
            'disks' => [
                'pages' => [
                    'driver' => 'local',
                    'root' => app_path('pages')
                ],
            ],
        ]
    ];
}
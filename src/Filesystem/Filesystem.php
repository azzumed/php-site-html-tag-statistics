<?php

namespace Parser\Filesystem;

use Parser\Contracts\FilesystemDriver;
use InvalidArgumentException;
use Parser\Filesystem\Drivers\LocalDriver;
use Parser\Filesystem\Drivers\HttpDriver;

class Filesystem
{
    protected static array $disks = [];

    public static function disk($name = null)
    {
        return static::get($name ?? static::getDefaultDisk());
    }

    public static function customDisk($name, $config)
    {
        return static::get($name, $config);
    }

    public static function getDefaultDisk()
    {
        return config()['filesystems']['default'];
    }

    protected static function adapt(FilesystemDriver $driver)
    {
        return new FilesystemAdapter($driver);
    }

    protected static function get($name, array $config = null)
    {
        return static::$disks[$name] ??= static::resolve($name, $config);
    }

    protected static function resolve($name, array $config = null)
    {
        $config ??= config()['filesystems']['disks'][$name] ?? [];

        if (empty($config['driver'])) {
            throw new InvalidArgumentException("Disk [{$name}] does not have a configured driver.");
        }

        $name = $config['driver'];

        $driverMethod = 'create' . ucfirst($name) . 'Driver';

        if (!method_exists(static::class, $driverMethod)) {
            throw new InvalidArgumentException("Driver [{$name}] is not supported.");
        }

        return call_user_func([static::class, $driverMethod], $config);
    }

    public static function createLocalDriver(array $config): FilesystemAdapter
    {
        return self::adapt(
            new LocalDriver($config['root'])
        );
    }

    public static function createHttpDriver(array $config): FilesystemAdapter
    {
        return self::adapt(
            new HttpDriver($config['root'])
        );
    }
}
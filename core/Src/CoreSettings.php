<?php

namespace core\Src;
use core\Src\Utils\PathResolver;
use Error;

class CoreSettings
{
    private static string $configs_dir = "";
    private static array $configs = [];

    public function __construct()
    {
        self::$configs_dir = PathResolver::get_core_configs_dir();
        self::load_configs();
    }

    public static function get_conf(string $conf_type)
    {
        if (!array_key_exists($conf_type, self::$configs)) {
            throw new Error("Config `$conf_type` not exist, check >>> core/Configs directory");
        }
        return self::$configs[$conf_type];

    }

    public static function get_root_views_dir(): string
    {
        return self::$configs['paths']['views'];
    }

    public static function get_root_routes_dir(): string
    {
        return self::$configs['paths']['routes'];
    }

    private static function load_configs(): void
    {
        foreach (array_diff(scandir(self::$configs_dir), array('.', '..')) as $config) {
            $name = explode('.', $config)[0];
            self::$configs[$name] = require_once self::$configs_dir."/$config";
        }
    }
}
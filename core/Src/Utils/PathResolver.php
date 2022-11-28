<?php

namespace core\Src\Utils;

class PathResolver
{
    public static function get_project_dir(): string
    {
        return dirname(__FILE__, 4);
    }

    public static function get_core_configs_dir(): string
    {
        return dirname(__FILE__, 3).'/Configs';
    }

    public static function get_project_config_path(): string
    {
//        echo '<br>'.__DIR__.'<<< __DIR__ this code is written in PathResolver.php';
//        echo '<br>'.__FILE__.'<<< __FILE__ this code is written in PathResolver.php';

        return dirname(__FILE__, 4).'/app/config.php';
    }

}


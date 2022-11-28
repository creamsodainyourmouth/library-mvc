<?php

namespace core\Src;
use Error;

class ProjectSettings
{
    private array $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get_path($path_of)
    {
        if (!array_key_exists($path_of, $this->config['paths'])) {
            throw new Error("Project config has not `$path_of` path, see project_dir/app/configs/paths.php");
        }
        return $this->config['paths'][$path_of];
    }

    public function get_db_conf(): array
    {
        // TODO: Throw Exception or return []?
        return $this->config['db'] ?? [];
    }

    public function get_app_conf(): array
    {
        return $this->config['app'] ?? [];
    }

    public function get_app_prefix()
    {
        return $this->get_app_conf()['app_prefix'];
    }

    public function __get(string $config_name)
    {
        if (! array_key_exists($config_name, $this->config)) {
            throw new Error("Config `$config_name` is not exist in ProjectsSettings. See app/configs");
        }
        return $this->config[$config_name];
    }

}
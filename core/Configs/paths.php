<?php
use core\Src\Utils\PathResolver;

define('PROJECT_DIR', PathResolver::get_project_dir());

const APP_DIR = PROJECT_DIR . '/app';

return [
    'project_dir' => PROJECT_DIR,
    'project_config' => PROJECT_DIR.'/app/paths.php',
    'app_dir'=> APP_DIR,
    'controllers'=> APP_DIR.'/Controllers',
    'models'=> APP_DIR.'/Models',
    'views'=> APP_DIR.'/Views',
    'routes'=> APP_DIR.'/Routes',

];

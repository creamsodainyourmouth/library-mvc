<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/Src/Utils/PHP_helper_functions.php';
require_once __DIR__.'/Src/helper_functions.php';

use core\Src\Application;
use core\Src\ProjectSettings;


$project_config = require_once __DIR__ . '/../app/config.php';
$project_settings = new ProjectSettings($project_config);


$app = new Application($project_settings);

function app() {
    global $app;
    return $app;
}

return $app;

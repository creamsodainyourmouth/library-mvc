<?php
const CONFIGS_DIR = __DIR__.'/configs';

$configs = array_diff(scandir(CONFIGS_DIR), array('.', '..'));

// Standard
//$main_config = [];

//foreach ($configs as $config) {
//    $config_name = explode('.', $config)[0];
//    $main_config[$config_name] = require_once CONFIGS_DIR."/$config";
//}


// PRO
//$conf_values = array_map(
//    function ($conf) {return require_once CONFIGS_DIR."/$conf";},
//    $configs
//);

//$configs = array_combine($configs, $conf_values);


// PRO MAX
$configs = array_flip(array_map(function ($conf) {return substr($conf, 0, -4); }, $configs));
array_walk($configs, function (&$v, $k) {$v = require_once CONFIGS_DIR."/$k.php";});

return $configs;

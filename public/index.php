<?php
declare(strict_types=1);

session_start();

$app = require_once __DIR__.'/../core/init.php';
$app->run();
<?php

require_once __DIR__ . "/../../vendor/autoload.php";
use superbot\App\Services\BroadcastService;
$container = require __DIR__ . "/../Configs/DIConfigs.php";

$broadcast = $container->get(BroadcastService::class);
$broadcast->init($argv[1], getmypid(), $argv[2]);
$broadcast->run();
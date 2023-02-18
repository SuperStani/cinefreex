<?php

use superbot\App\Storage\TransferData;
require __DIR__."/../../vendor/autoload.php";

$container = require __DIR__."/../Configs/DIConfigs.php";

$transfer = $container->get(TransferData::class);
$transfer->transferFilms();
$transfer->transferSeries();
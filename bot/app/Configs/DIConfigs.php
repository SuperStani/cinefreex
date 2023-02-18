<?php

use superbot\App\Configs\DBConfigs;

use \DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use function DI\autowire;
use function DI\factory;
use \Redis as Redis;
use \PDO as PDO;

$conf = [
    PDO::class => factory(function () {
        return new PDO("mysql:host=" . DBConfigs::$dbhost . ";dbname=" . DBConfigs::$dbname, DBConfigs::$dbuser, DBConfigs::$dbpassword);
    }),
    Redis::class => factory(function() {
        $redis = new Redis();
        $redis->connect(DBConfigs::$redishost, DBConfigs::$redisport);
        return $redis;
    })
];

$builder = new ContainerBuilder();
$builder->addDefinitions($conf);
return $builder->build();

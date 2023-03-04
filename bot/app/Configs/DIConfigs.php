<?php

use \superbot\App\Configs\Interfaces\DatabaseCredentials;
use \superbot\App\Configs\Interfaces\RedisCredentials;

use \DI\ContainerBuilder;
use function DI\factory;


$conf = [
    \PDO::class => factory(function () {
        return new \PDO(
            "mysql:host=" . DatabaseCredentials::HOST . ";dbname=" . DatabaseCredentials::DBNAME,
            DatabaseCredentials::USER,
            DatabaseCredentials::PASSWORD
        );
    }),
    \Redis::class => factory(function() {
        $redis = new \Redis();
        $redis->connect(RedisCredentials::SOCK);
        return $redis;
    })
];

$builder = new ContainerBuilder();
$builder->addDefinitions($conf);
return $builder->build();

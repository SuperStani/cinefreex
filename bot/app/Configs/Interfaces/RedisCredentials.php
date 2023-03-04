<?php

namespace superbot\App\Configs\Interfaces;

interface RedisCredentials
{
    public const HOST = "127.0.0.1";
    public const PORT = "6379";
    public const SOCK = "/var/run/redis/redis-server.sock";
}
<?php

namespace Hedonist\Services;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Redis;

class RedisCache implements Store
{
    public function get($key)
    {
        return Redis::get($key);
    }

    public function many(array $keys)
    {
        //TODO
    }

    public function put($key, $value, $minutes)
    {
        return Redis::setex($key, $minutes * 60, $value);
    }

    public function putMany(array $values, $minutes)
    {
        //TODO
    }

    public function increment($key, $value = 1)
    {
        //TODO
    }

    public function decrement($key, $value = 1)
    {
        //TODO
    }

    public function forever($key, $value)
    {
        //TODO
    }

    public function forget($key)
    {
        //TODO
    }

    public function flush()
    {
        return Redis::flushall();
    }

    public function getPrefix()
    {
        //TODO
    }
}
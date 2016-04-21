<?php

namespace App\Daos;

class TestDao extends BaseDao
{
    const KEY = 'test';

    public function get($id, $field)
    {
        return static::redisHGet($id, self::KEY, $field);
    }

    public function mget($id, $fields)
    {
        return static::redisHMGet($id, self::KEY, $fields);
    }

    public function mset($id, $data)
    {
        return static::redisHMSet($id, self::KEY, $data);
    }
}

<?php

namespace App\Daos;

use TinyPHP\Helper\DBHelper;
use TinyPHP\Helper\RedisHelper;
use Container;
use Exception;

class BaseDao
{
    protected $dbmod = 'main';
    protected $entity;
    public static $sharedb = true;

    public function __constrcut()
    {
    }

    public function db($mod = null)
    {
        $dbmod = $mod == null ? $this->dbmod : $mod;
        $name = 'dbclient'.$dbmod;
        if (static::$sharedb && ($db = Container::instance($name))) {
            $db->table($this->entity, true);

            return $db;
        }

        $conf = config('app.mysql');
        if (!isset($conf[$mod])) {
            throw new Exception('mysql config not found:'.$mod, 1);
        }

        $db = new DBHelper($conf[$mod]);
        $db->table($this->entity, true);
        if (static::$sharedb) {
            Container::instance($name, $db);
        }

        return $db;
    }

    public function disableShareDB()
    {
        static::$sharedb = false;
    }

    public static function redis($mod, $hashId = 0)
    {
        $name = 'redis'.$mod;
        $redis = Container::instance($name);
        if ($redis) {
            return $redis;
        }

        $redisConf = config('app.redis');
        if (!isset($redisConf[$mod])) {
            throw new Exception('redis config not found:'.$mod, 1);
        }

        if ($hashId) {
            $hashConf = $redisConf[$mod];
            $conf = [];
            foreach ($hashConf as $value) {
                if ($value['rate'] > $hashId) {
                    break;
                }
                $conf = $value;
            }
        } else {
            $conf = $redisConf[$mod];
        }

        $redis = new RedisHelper($conf, true);
        Container::instance($name, $redis);

        return $redis;
    }

    public static function hashId($id)
    {
        return $id % 128;
    }

    public static function redisHGet($id, $key, $field)
    {
        $hashId = static::hashId($id);
        $key = static::makeKey($id, $key);

        return static::redis('hash', $hashId)->hGet($key, $field);
    }

    public static function redisHMGet($id, $key, $fields)
    {
        $hashId = static::hashId($id);
        $key = static::makeKey($id, $key);

        return static::redis('hash', $hashId)->hMGet($key, $fields);
    }

    public static function redisHMSet($id, $key, array $data)
    {
        $hashId = static::hashId($id);
        $key = static::makeKey($id, $key);

        return static::redis('hash', $hashId)->hMSet($key, $data);
    }

    public static function makeKey($id, $key)
    {
        return $key.':'.$id;
    }
}

<?php

use App\Common\AppException;
use App\Common\ViewException;

class Container
{
    public static $instances = array();

    public static function instance($name, $instance = null)
    {
        if (isset(self::$instances[$name])) {
            return self::$instances[$name];
        }

        if ($instance) {
            self::$instances[$name] = $instance;
        }

        return $instance;
    }
}

function service($name)
{
    if (is_array($name)) {
        $className = 'App\\Services\\'.$name[0].'\\'.$name[1].$name[0];
    } else {
        $className = 'App\\Services\\'.$name.'Service';
    }

    if ($instance = Container::instance($className)) {
        return $instance;
    }

    return Container::instance($className, new $className());
}

function dao($name)
{
    $className = 'App\\Daos\\'.$name.'Dao';
    if ($instance = Container::instance($className)) {
        return $instance;
    }

    return Container::instance($className, new $className());
}

function entity($name)
{
    $className = 'App\\Entitys\\'.$name.'Entity';
    if ($instance = Container::instance($className)) {
        return $instance;
    }

    return Container::instance($className, new $className());
}

function error($code, $msg, $params = [])
{
    throw new AppException($code, $msg, $params);
}

function viewError($e)
{
    throw new ViewException($e->getCode(), $e->getMessage());
}

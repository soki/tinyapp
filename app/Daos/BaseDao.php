<?php

namespace App\Daos;

use TinyPHP\Database\Client as DBClient;
use Pheanstalk\Pheanstalk;
use Container;

class BaseDao
{
    protected $dbmod = 'mysql_main';
    protected $entity;
    public static $sharedb = true;

    public function __constrcut()
    {
    }

    private function getDBConfig($dbmod)
    {
        $conf = config('app'.$dbmod);
        if (empty($conf)) {
            return error(500, 'getdbconfig', $dbmod);
        }

        return $conf;
    }

    public function disableShareDBClient()
    {
        static::$sharedb = false;
    }

    public function dbClient($dbmod = null)
    {
        $dbmod = $dbmod == null ? $this->dbmod : $dbmod;
        $name = 'dbclient'.$dbmod;
        if (static::$sharedb && ($client = Container::instance($name))) {
            $client->table($this->entity, true);

            return $client;
        }

        $conf = $this->getDBConfig($dbmod);
        $client = new DBClient($conf);
        $client->table($this->entity, true);
        if (static::$sharedb) {
            Container::instance($name, $client);
        }

        return $client;
    }

    public function beanstalkdClient()
    {
        $name = 'queueclient';
        $pheanstalk = Container::instance($name);
        if ($pheanstalk) {
            return $pheanstalk;
        }

        $conf = config('app.queue');
        $pheanstalk = new Pheanstalk($conf['host'], $conf['port']);
        Container::instance($name, $pheanstalk);

        return $pheanstalk;
    }
}

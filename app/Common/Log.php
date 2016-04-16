<?php

namespace App\Common;

class Log
{
    const NOTICE = 'notice';
    const WARNING = 'warning';
    const ERROR = 'error';

    public static function info($msg, $params)
    {
        static::write('info.log', static::makeParams('info', $msg, $params));
    }

    public static function user($uid, $msg, $params)
    {
        $params['_uid'] = $uid;
        static::write('user.log', static::makeParams('user', $msg, $params));
    }

    // level [notice warning error]
    public static function error($level, $msg, $params)
    {
        static::write('error.log', static::makeParams($level, $msg, $params));
    }

    public static function write($file, $s)
    {
        $fileName = config('app.logdir').DS.$file;
        if (!file_exists($fileName)) {
            touch($fileName);
            chmod($fileName, 0777);
        }
        error_log($s."\n", 3, $fileName);
    }

    public static function makeParams($level, $msg, $params)
    {
        $data['level'] = $level;
        $data['date'] = date('Y-m-d H:i:s');
        $data['msg'] = $msg;
        $data['data'] = $params;

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

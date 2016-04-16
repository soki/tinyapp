<?php

namespace App\Common;

use Exception;

class AppException extends Exception
{
    public $logLevel = [
        400 => Log::WARNING,
        500 => Log::ERROR,
    ];

    public function __construct($code, $msg, $params = '')
    {
        if (isset($this->logLevel[$code])) {
            $level = $this->logLevel[$code];
        } else {
            $level = Log::NOTICE;
        }

        Log::error($level, $msg, $params);
        parent::__construct($msg, $code);
    }
}

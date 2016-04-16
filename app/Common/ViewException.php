<?php

namespace App\Common;

use Exception;

class ViewException extends Exception
{
    public function __construct($code, $msg)
    {
        parent::__construct($msg, $code);
    }
}

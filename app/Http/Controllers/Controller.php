<?php

namespace App\Http\Controllers;

use TinyPHP\Http\Controller as BaseController;
use TinyPHP\Http\Response;
use App\Common\ViewException;
use App\Common\AppException;
use App\Common\Log;

class Controller extends BaseController
{
    public function __construct()
    {
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function exceptionHandler($exception)
    {
        $data = array(
            'code' => $exception->getCode(),
            'msg' => $exception->getMessage(),
        );

        $appError = ($exception instanceof AppException);
        $viewError = ($exception instanceof ViewException);
        if (!$appError && !$viewError) {
            $logs = $data;
            $logs['file'] = $exception->getFile();
            $logs['line'] = $exception->getLine();
            $logs['trace'] = $exception->getTrace()[0];

            Log::error(Log::ERROR, $logs);
        }

        if ($viewError) {
            return $this->view('error', $data)->send();
        }

        $result = json_encode($data, JSON_UNESCAPED_UNICODE);

        return (new Response($result))->send();
    }

    public function json($data = [], $code = 0, array $headers = [])
    {
        $result['code'] = $code;
        $result['data'] = $data;

        $headers = ['Content-type' => 'application/json'];

        return new Response(json_encode($result, JSON_UNESCAPED_UNICODE), 200, $headers);
    }

    public function view($name, $data = [], $status = 200, array $headers = [])
    {
        return (new Response($data, $status, $headers))->view($name);
    }

    public function text($content, $status = 200, array $headers = [])
    {
        return new Response($content, $status, $headers);
    }

    public function redirect($url, $headers = [])
    {
        return (new Response('', 302, $headers))->redirect($url);
    }
}

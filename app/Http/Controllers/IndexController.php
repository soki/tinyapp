<?php

namespace App\Http\Controllers;

use TinyPHP\Http\Request;

class IndexController extends Controller
{
    public function hello(Request $request)
    {
        return 'hello world';

        //return $this->view('hello', ['hello' => 'hello world']);
        //return $this->json(['hello' => 'hello world']);
    }
}

<?php

namespace app\controllers;

use app\core\Request;

class HomeController
{
    public static function index()
    {
        return "HELLO";
    }

    public static function contactPost(Request $request)
    {
        return $request->getMethod();

        return $request->getBody()['full_name'];
    }
}
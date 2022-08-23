<?php

namespace app\controllers;

use app\core\Request;

class HomeController
{
    public static function index()
    {
        return "This application is based on api. Please check Readme.md file to see how to work with it.";
    }

    public static function contactPost(Request $request)
    {
        return $request->getMethod();

        return $request->getBody()['full_name'];
    }
}
<?php

namespace app\controllers;

use app\core\Request;
use app\core\Validation;
use app\models\Car;

class HomeController
{
    public static function index()
    {
        return "This application is based on api. Please check README.md file to see how to work with it.";
    }
}
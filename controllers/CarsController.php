<?php

namespace app\controllers;

use app\core\Request;
use app\libs\Files;
use app\models\Car;

class CarsController
{
    public static function index()
    {
        return "SHOW ALL CARS INFORMATION";
    }

    public static function store()
    {
        /*$json = file_get_contents(__DIR__ . '/../public/files/source-2.json');
        $json_data = json_decode($json,true);
        return var_dump($json_data);*/
        /*if (($open = fopen(__DIR__ . "/../public/files/source-1.csv", "r")) !== FALSE)
        {
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE)
            {
                $array[] = $data;
            }
            fclose($open);
            return var_dump($array);
        }*/
        /*return var_dump(array_diff(scandir(__DIR__ . "/../public/files"), ['.', '..']));*/
        $uploadedFile = new Files();
        return var_dump($uploadedFile->filesArray);
    }

    public function show(Car $car)
    {
    }

    public function update(Request $request, Car $car)
    {
    }

    public function destroy(Car $car)
    {
    }
}
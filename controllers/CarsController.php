<?php

namespace app\controllers;

use app\core\Request;
use app\libs\Files\Files;
use app\models\Car;

class CarsController
{
    public static function import()
    {
        $objFile = new Files();
        $objCar = new Car();

        $objCar->getDB()->truncateTable('car');
        $contentsArray = $objFile->fileContent();
        foreach ($contentsArray as $contents) {
            foreach ($contents as $content) {
                $objCar->save($content);
            }
        }

        return json_encode(['message' => 'All Data Imported Successfully']);
    }

    public static function index()
    {
        $objCar = new Car();

        return $objCar->all();
    }

    public static function store(Request $request)
    {
        $objCar = new Car();

        return $objCar->save($request->getBody());
        /*
        {
            "Car Brand": "Kia",
            "Car Model": "Pride",
            "Car year": "2022",
            "Location": "Iran",
            "License plate": "IR 75 Z 222",
            "Car km": "10",
            "Number of doors": "4",
            "Number of seats": "4",
            "Fuel type": "Petrol",
            "Transmission": "Manual",
            "Car Type Group": "Car",
            "Car Type": "Small car",
            "Inside height": "5.22",
            "Inside length": "1.44",
            "Inside width": "2.50"
        }
     */
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
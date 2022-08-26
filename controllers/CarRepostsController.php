<?php

namespace app\controllers;

use app\core\Request;
use app\models\Car;
use app\models\CarBrand;

class CarRepostsController
{
    public static function brand(Request $request)
    {
        if(array_key_exists('brand', $request->getBody())) {
            $objCar = new Car();
            $brand = $request->getBody()['brand'];
            $objCarBrand = new CarBrand();
            if(count($objCarBrand->byTitle($brand)) > 0) {
                $brand_id = $objCarBrand->byTitle($brand)[0]['id'];
                if(strlen($objCar->search(['car_brand_id'], [$brand_id])) > 0) {
                    return $objCar->search(['car_brand_id'], [$brand_id]);
                }
                return json_encode(['message' => 'Car not found']);
            }
            return json_encode(['message' => 'Brand not found']);
        }
        return json_encode(['message' => 'invalid filed name']);
    }
    public static function year(Request $request)
    {
        if(array_key_exists('year', $request->getBody())) {
            $objCar = new Car();
            $car_year = $request->getBody()['year'];
            return $objCar->search(['car_year'], [$car_year]);
        }
        return json_encode(['message' => 'invalid filed name']);
    }
}
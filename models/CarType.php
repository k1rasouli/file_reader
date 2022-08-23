<?php

namespace app\models;

use app\core\Model;

class CarType extends Model
{
    public string $car_type;
    public array $rules = [
        'car_type' => ['required']
    ];
    public function validate()
    {
    }
}
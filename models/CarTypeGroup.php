<?php

namespace app\models;

use app\core\Model;

class CarTypeGroup extends Model
{
    public string $car_type_group;
    public array $rules = [
        'car_type_group' => ['required']
    ];
    public function validate()
    {
    }
}
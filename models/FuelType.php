<?php

namespace app\models;

use app\core\Model;

class FuelType extends Model
{
    public string $fuel_type;
    public array $rules = [
        'fuel_type' => ['required'],
    ];

    public function validate()
    {
    }
}
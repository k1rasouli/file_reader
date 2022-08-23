<?php

namespace app\models;

use app\core\Model;

class Car extends Model
{
    public string $transmission;

    public array $rules = [
        'car_brand_id' => ['required', 'unsignedBigInt'],
        'car_model_id' => ['required', 'unsignedBigInt'],
        'car_year' => ['required', ['min' => 1950], ['max' => 'currentYear']],
        'location_id' => ['required', 'unsignedBigInt'],
        'license_plate' => ['required', 'unique'],
        'car_km' => ['required', 'unsignedBigInt'],
        'number_of_doors' => ['required', 'unsignedInt'],
        'number_of_seats' => ['required', 'unsignedInt'],
        'fuel_type_id' => ['required', 'unsignedBigInt'],
        'transmission_id' => ['required', 'unsignedBigInt'],
        'car_type_group_id' => ['required', 'unsignedBigInt'],
        'car_type_id' => ['required', 'unsignedBigInt'],
        'inside_height' => ['required', 'unsignedBigInt'],
        'inside_length' => ['required', 'unsignedBigInt'],
        'inside_width' => ['required', 'unsignedBigInt'],
    ];

    public function validate()
    {
    }
}
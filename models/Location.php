<?php

namespace app\models;

use app\core\Model;

class Location extends Model
{
    public string $location_title;
    public array $rules = [
        'location_title' => ['required']
    ];
    public function validate()
    {
    }
}
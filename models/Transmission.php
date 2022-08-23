<?php

namespace app\models;

use app\core\Model;

class Transmission extends Model
{
    public string $transmission;
    public array $rules = [
        'transmission' => ['required'],
    ];

    public function validate()
    {
    }
}
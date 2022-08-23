<?php

namespace app\models;

use app\core\Model;

class CarModel extends Model
{
    public string $card_model_title;
    public array $rules = [
        'card_model_title' => ['required']
    ];
    public function validate()
    {
    }
}
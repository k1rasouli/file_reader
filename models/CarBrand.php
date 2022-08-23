<?php

namespace app\models;

use app\core\Model;

class CarBrand extends Model
{
    public string $card_brand_title;
    public array $rules = [
        'card_brand_title' => ['required']
    ];
    public function __construct()
    {
    }

    public function validate()
    {

    }
}
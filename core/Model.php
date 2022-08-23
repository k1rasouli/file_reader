<?php

namespace app\core;

abstract class Model implements interfaces\Model
{
    public array $rules = [];

    public function validate()
    {
    }
}
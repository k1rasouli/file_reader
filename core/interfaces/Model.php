<?php

namespace app\core\interfaces;

interface Model
{
    public function validate($key, $value);

    public function save(array $fields);

    public function find($id);
}
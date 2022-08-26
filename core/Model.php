<?php

namespace app\core;

abstract class Model implements interfaces\Model
{
    public Database $db;
    public Validation $validation;
    public array $rules = [];

    public function __construct()
    {
    }

    public function validate($key, $value)
    {
    }

    public function save(array $fields)
    {
    }

    public function find($id)
    {
    }

    public function getDB()
    {
        $this->db = new Database();

        return $this->db;
    }

    public function getValidation()
    {
        $this->validation = new Validation();

        return $this->validation;
    }
}
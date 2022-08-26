<?php

namespace app\models;

use app\core\Model;

class CarType extends Model
{
    protected $table = "car_type";
    public string $car_type;
    public array $rules = [
        'car_type' => ['required'],
    ];

    public function validate($key, $value)
    {
        foreach ($this->rules as $rule) {
            if ($this->getValidation()->{$rule[0]}($value)) {
                if (count($this->byTitle($value)) == 0) {
                    $this->save([$value]);
                }

                return $this->byTitle($value)['0']['id'];
            } else {
                return false;
            }
        }
    }

    public function save(array $fields)
    {
        return $this->getDB()->executeStaments($this->table, "INSERT", ['car_type'], $fields);
    }

    public function find($id)
    {
    }

    public function byTitle($title)
    {
        return $this->getDB()
            ->executeStaments($this->table, "SELECT", ['car_type'], [$title], "id ASC", ['id', 'car_type', 'created_at']
            )->fetchAll();
    }
}
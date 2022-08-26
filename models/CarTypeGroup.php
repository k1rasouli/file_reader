<?php

namespace app\models;

use app\core\Model;

class CarTypeGroup extends Model
{
    protected $table = "car_type_group";
    public string $car_type_group;
    public array $rules = [
        'car_type_group' => ['required'],
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
        return $this->getDB()->executeStaments($this->table, "INSERT", ['car_type_group'], $fields);
    }

    public function find($id)
    {
    }

    public function byTitle($title)
    {
        return $this->getDB()
            ->executeStaments(
                $this->table,
                "SELECT", ['car_type_group'],
                [$title],
                "id ASC",
                ['id', 'car_type_group', 'created_at']
            )->fetchAll();
    }
}
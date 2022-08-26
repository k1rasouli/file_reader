<?php

namespace app\models;

use app\core\Model;

class Transmission extends Model
{
    protected $table = "transmission";
    public string $transmission;
    public array $rules = [
        'transmission' => ['required'],
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
        return $this->getDB()->executeStaments($this->table, "INSERT", ['transmission'], $fields);
    }

    public function find($id)
    {
    }

    public function byTitle($title)
    {
        return $this->getDB()
            ->executeStaments(
                $this->table,
                "SELECT", ['transmission'],
                [$title],
                "id ASC",
                ['id', 'transmission', 'created_at']
            )->fetchAll();
    }
}
<?php

namespace app\models;

use app\core\Database;
use app\core\Model;
use app\core\Validation;

class Location extends Model
{
    protected $table = "location";
    public string $location_title;
    public array $rules = [
        'location_title' => ['required'],
    ];

    public function __construct()
    {
    }

    public function validate($key, $value)
    {
        foreach ($this->rules as $rule) {
            if ($this->getValidation()->{$rule[0]}($value)) {
                if (count($this->byTitle($value)) == 0) {
                    return $this->save([$value]);
                }

                return $this->byTitle($value)['0']['id'];
            } else {
                return false;
            }
        }
    }

    public function save(array $fields)
    {
        return $this->getDB()->executeStaments($this->table, "INSERT", ['location_title'], $fields);
    }

    public function find($id)
    {
    }

    public function byTitle($title)
    {
        return $this->getDB()
            ->executeStaments(
                $this->table,
                "SELECT", ['location_title'],
                [$title],
                "id ASC",
                ['id', 'location_title', 'created_at']
            )->fetchAll();
    }
}
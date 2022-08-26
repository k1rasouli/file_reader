<?php

namespace app\models;

use app\core\Model;

class CarBrand extends Model
{
    protected $table = "car_brand";
    public string $card_brand_title;
    public array $rules = [
        'card_brand_title' => ['required'],
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
        return $this->getDB()->executeStaments($this->table, "INSERT", ['card_brand_title'], $fields);
    }

    public function find($id)
    {
    }

    public function byTitle($title)
    {
        return $this->getDB()
            ->executeStaments(
                $this->table,
                "SELECT", ['card_brand_title'],
                [$title],
                "id ASC",
                ['id', 'card_brand_title', 'created_at']
            )->fetchAll();
    }
}
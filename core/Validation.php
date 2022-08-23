<?php

namespace app\core;

use app\core\interfaces\Validaton;

class Validation implements Validaton
{

    public static function required($value)
    {
        return !is_null($value) && $value != "";
    }

    public static function unsignedBigInt($value)
    {
        return $value >= 0 && $value <= 9223372036854775807;
    }

    public static function min($value, $min)
    {
        return $value >= $min;
    }

    public static function max(mixed $value, $max)
    {
        if(is_string($max)) {
            return match ($max) {
                'currentYear' => $value <= date('Y'),
                default => false,
            };
        }
        return $value <= $max;
    }

    public static function unique(string $table, $field, $value)
    {
        $db = new Database();
        $statement = $db->executeStaments($table, 'SELECT', [$field], [$value]);
        if(count($statement->fetchAll()) == 0)
            return true;
        return false;
    }
}
<?php

namespace app\core\interfaces;

interface Validaton
{
    public static function required($value);
    public static function unsignedBigInt($value);
    public static function min($value, $min);
    public static function max(mixed $value, $max);
    public static function unique(string $table, $field, $value);
}
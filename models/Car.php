<?php

namespace app\models;

use app\core\Model;

class Car extends Model
{
    protected $table = "car";
    private $selectStartSQL = "
            SELECT 
                car.id,
                car_brand.card_brand_title AS 'Car Brand',
                car_model.card_model_title AS 'Car Model' ,
                car.car_year AS 'Car year',
                location.location_title AS 'Car Location',
                car.license_plate AS 'License plate',
                car.car_km AS 'Car km',
                car.number_of_doors AS 'Number of doors',
                car.number_of_seats AS 'Number of seats',
                fuel_type.fuel_type AS 'Fuel type',
                transmission.transmission AS 'Transmission',
                car_type_group.car_type_group AS 'Car Type Group',
                car_type.car_type AS 'Car Type',
                (car.inside_height / 100) AS 'Inside height',
                (car.inside_length / 100) AS 'Inside length',
                (car.inside_width / 100) AS 'Inside width',
                car.created_at AS 'Created At'
            from car
            LEFT JOIN car_brand ON car.car_brand_id = car_brand.id 
            LEFT JOIN car_model ON car.car_model_id = car_model.id
            LEFT JOIN location ON car.location_id = location.id
            LEFT JOIN fuel_type ON car.fuel_type_id = fuel_type.id
            LEFT JOIN transmission ON car.transmission_id = transmission.id
            LEFT JOIN car_type_group ON car.car_type_group_id = car_type_group.id
            LEFT JOIN car_type ON car.car_type_id = car_type.id
        ";
    public array $rules = [
        'car_brand_id' => ['required', 'unsignedBigInt'],
        'car_model_id' => ['required', 'unsignedBigInt'],
        'car_year' => ['required', ['min' => 1950], ['max' => 'currentYear']],
        'location_id' => ['unsignedBigInt'],
        'license_plate' => ['unique'],
        'car_km' => ['unsignedBigInt'],
        'number_of_doors' => ['unsignedInt'],
        'number_of_seats' => ['unsignedInt'],
        'fuel_type_id' => ['unsignedBigInt'],
        'transmission_id' => ['unsignedBigInt'],
        'car_type_group_id' => ['unsignedBigInt'],
        'car_type_id' => ['unsignedBigInt'],
        'inside_height' => ['unsignedBigInt'],
        'inside_length' => ['unsignedBigInt'],
        'inside_width' => ['unsignedBigInt'],
    ];

    public array $fieldsList = [
        'Car Brand' => ['car_brand_id', 'CarBrand'],
        'Car Model' => ['car_model_id', 'CarModel'],
        'Car year' => ['car_year', ''],
        'Location' => ['location_id', 'Location'],
        'License plate' => ['license_plate', ''],
        'Car km' => ['car_km', ''],
        'Number of doors' => ['number_of_doors', ''],
        'Number of seats' => ['number_of_seats', ''],
        'Fuel type' => ['fuel_type_id', 'FuelType'],
        'Transmission' => ['transmission_id', 'Transmission'],
        'Car Type Group' => ['car_type_group_id', 'CarTypeGroup'],
        'Car Type' => ['car_type_id', 'CarType'],
        'Inside height' => ['inside_height', ''],
        'Inside length' => ['inside_length', ''],
        'Inside width' => ['inside_width', ''],
    ];

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
    }

    public function validate($key, $value)
    {
        $filed = $this->fieldsList[$key];
        if ( ! is_null($value)) {
            if (strlen($filed[1]) > 0) {
                $className = 'app\\models\\'.$filed[1];
                $filedObject = new $className();

                return $filedObject->validate($key, $value);
            } else {
                //validate rules for no class validation
                foreach ($this->rules[$filed[0]] as $rule) {
                    if (is_string($rule)) {
                        switch ($rule) {
                            case 'unique':
                                if ($this->getValidation()->unique($this->table, 'license_plate', $value)) {
                                    return $value;
                                }

                                return false;
                            default:
                                if ($this->getValidation()->{$rule}($value)) {
                                    return $value;
                                }

                                return false;
                        }
                    } else {
                        if ($this->getValidation()->{$rule[0]}($value, $rule[1])) {
                            return $value;
                        }
                    }
                }
            }
        } else {
            if (in_array('required', $this->rules[$filed[0]])) {
                return false;
            }
        }

        return $value;
    }

    public function save(array $fields)
    {
        $dbFields = [];
        $dbValues = [];
        foreach ($fields as $key => $value) {
            if (array_key_exists($key, $this->fieldsList)) {
                $dbFiledName = $this->fieldsList[$key][0];
                if ($this->validate($key, $value)) {
                    if (strpos($value, '.') > 0) {
                        $value = str_replace('.', '', $value);
                    }
                    $dbFields[$dbFiledName] = $dbFiledName;
                    $dbValues[] = $this->validate($key, $value);
                }
                //if you uncomment this else entire row will be skipped.
                // now the validation system replaces in valid value with null
                /*else {
                    return json_encode(['message' => 'Validation Failed On: ' . $key]);
                }*/
            }
        }
        try {
            $this->getDB()->executeStaments($this->table, 'INSERT', $dbFields, $dbValues);

            return json_encode(['message' => 'Car Added Successfully']);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function find($id)
    {
    }

    public function all()
    {
        $statement = $this->getDB()->pdo->prepare($this->selectStartSQL);
        $statement->execute();

        return json_encode($statement->fetchAll(\PDO::FETCH_CLASS));
    }

    public function search($fields, $values)
    {
        $searchStatement = $this->getDB()->pdo->prepare(
            $this->selectStartSQL." WHERE ".$this->getDB()->prepareFileds($fields, true)
        );
        foreach ($this->getDB()->prepareValues($values, false, $fields) as $preparedValue) {
            $searchStatement->execute($preparedValue);
        }

        return json_encode($searchStatement->fetchAll(\PDO::FETCH_CLASS));
    }
}
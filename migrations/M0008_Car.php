<?php

namespace app\migrations;

use app\core\Database;

class M0008_Car extends Database
{
    private $tableName = "car";

    public function up()
    {
        $this->tableActions(
            "CREATE",
            $this->tableName,
            [
                'id BIGINT AUTO_INCREMENT PRIMARY KEY',
                'car_brand_id BIGINT NOT NULL',
                'car_model_id BIGINT NOT NULL',
                'car_year INT NOT NULL',
                'location_id BIGINT NULL DEFAULT NULL',
                'license_plate VARCHAR(255) NULL DEFAULT NULL',
                'car_km BIGINT NULL DEFAULT NULL',
                'number_of_doors INT NULL DEFAULT NULL',
                'number_of_seats INT NULL DEFAULT NULL',
                'fuel_type_id BIGINT NULL DEFAULT NULL',
                'transmission_id BIGINT NULL DEFAULT NULL',
                'car_type_group_id BIGINT NULL DEFAULT NULL',
                'car_type_id BIGINT NULL DEFAULT NULL',
                'inside_height BIGINT NULL DEFAULT NULL',
                'inside_length BIGINT NULL DEFAULT NULL',
                'inside_width BIGINT NULL DEFAULT NULL',
                'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'UNIQUE (license_plate)',
            ],
            ",FOREIGN KEY (car_brand_id) REFERENCES car_brand(id),".
            " FOREIGN KEY (location_id) REFERENCES location(id),".
            " FOREIGN KEY (car_model_id) REFERENCES car_model(id),".
            " FOREIGN KEY (fuel_type_id) REFERENCES fuel_type(id),".
            " FOREIGN KEY (transmission_id) REFERENCES transmission(id),".
            " FOREIGN KEY (car_type_group_id) REFERENCES car_type_group(id),".
            " FOREIGN KEY (car_type_id) REFERENCES car_type(id)"
        );
    }

    public function down()
    {
        $this->tableActions(
            "DROP",
            $this->tableName
        );
    }
}
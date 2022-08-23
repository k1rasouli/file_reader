<?php

namespace app\migrations;

use app\core\Database;

class M0004_FuelType extends Database
{
    private $tableName = "fuel_type";
    public function up()
    {
        $this->tableActions(
            "CREATE",
            $this->tableName,
            [
                'id BIGINT AUTO_INCREMENT PRIMARY KEY',
                'fuel_type VARCHAR(255)',
                'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            ]
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
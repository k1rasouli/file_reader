<?php

namespace app\migrations;

use app\core\Database;

class M0006_CarTypeGroup extends Database
{
    private $tableName = "car_type_group";

    public function up()
    {
        $this->tableActions(
            "CREATE",
            $this->tableName,
            [
                'id BIGINT AUTO_INCREMENT PRIMARY KEY',
                'car_type_group VARCHAR(255)',
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
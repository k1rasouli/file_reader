<?php

namespace app\migrations;

use app\core\Database;

class M0001_CarBrand extends Database
{
    private $tableName = "car_brand";
    public function up()
    {
        $this->tableActions(
            "CREATE",
            $this->tableName,
            [
                'id BIGINT AUTO_INCREMENT PRIMARY KEY',
                'card_brand_title VARCHAR(255)',
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
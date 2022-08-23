<?php

namespace app\migrations;

use app\core\Database;

class M0003_Location extends Database
{
    private $tableName = "location";
    public function up()
    {
        $this->tableActions(
            "CREATE",
            $this->tableName,
            [
                'id BIGINT AUTO_INCREMENT PRIMARY KEY',
                'location_title VARCHAR(255)',
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
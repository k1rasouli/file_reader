<?php

namespace app\migrations;

use app\core\Database;

class M0005_Transmission extends Database
{
    private $tableName = "transmission";

    public function up()
    {
        $this->tableActions(
            "CREATE",
            $this->tableName,
            [
                'id BIGINT AUTO_INCREMENT PRIMARY KEY',
                'transmission VARCHAR(255)',
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
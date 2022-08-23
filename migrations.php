<?php

require_once __DIR__.'/vendor/autoload.php';

use app\core\Application;

$app = new Application();
$db = new \app\core\Database();

if (count($argv) > 1) {
    if ($argv[1] === "down") {
        callLastDown($db);
    } else {
        echo "Invalid argument".PHP_EOL;
    }
} else {
    $db->applyMigrations();
}

function callLastDown($db)
{
    $migratedTables = $db->getAppliedMigrations();
    if (count($migratedTables) > 0) {
        $lastTableFile = $migratedTables[0];
        $instance =  $db->createMigrationClassInstance($lastTableFile);
        echo "Rolling back migration " . $lastTableFile . PHP_EOL;
        $instance->down();
        echo $lastTableFile . " rolled back" . PHP_EOL;
    } else {
        echo "No migrated table found" . PHP_EOL;
    }
}
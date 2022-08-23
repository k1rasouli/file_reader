<?php

namespace app\core;

class Database
{
    public \PDO $pdo;
    private $dsn;
    private $user;
    private $password;

    public function __construct()
    {
        $this->dsn = getenv('DB_DSN');
        $this->user = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');
        $this->pdo = new \PDO($this->dsn, $this->user, $this->password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $newMigrations = [];
        $files = scandir(__DIR__.'/../migrations');
        $toApplyMigrations = array_diff($files, array_merge($appliedMigrations, ['.', '..']));
        foreach ($toApplyMigrations as $migration) {
            $instance = $this->createMigrationClassInstance($migration);
            echo "Migrating $migration.".PHP_EOL;
            $instance->up();
            echo "$migration migrated.".PHP_EOL;
            $newMigrations[] = $migration;
        }

        if ( ! empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            echo "All migrations are applied".PHP_EOL;
        }
    }

    private function createMigrationsTable()
    {
        $fileds = [
            'id BIGINT AUTO_INCREMENT PRIMARY KEY',
            'migration VARCHAR(255)',
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ];
        $this->tableActions('create', 'migrations', $fileds);
    }

    public function getAppliedMigrations()
    {
        $this->createMigrationsTable();
        $statement = $this->executeStaments("migrations", "SELECT", ['migration'], [], "created_at DESC");

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $this->executeStaments("migrations", "INSERT", ['migration'], $migrations);
    }

    protected function tableActions(string $type, string $table, array $fields = [], string $relations = "")
    {
        switch (strtoupper($type)) {
            case "CREATE":
                $sql = "CREATE TABLE IF NOT EXISTS ".$table." (".implode(",", $fields).$relations.") ";
                break;
            case "DROP":
                $sql = "DROP TABLE IF EXISTS ".$table;
                break;
        }
        $this->pdo->exec($sql);
    }

    protected function executeStaments(string $table, $statementType, array $fields, array $values = [], string $orderBy = "id ASC")
    {
        $SQL = "";
        switch ($statementType) {
            case "SELECT":
                if (count($values) == 0) {
                    $SQL = "SELECT ".$this->prepareFileds($fields)." FROM ".$table." ORDER BY ".$orderBy;
                }
                break;
            case "INSERT":
                $SQL = "INSERT INTO ".$table." ".$this->prepareFileds($fields)." VALUES ".$this->prepareValues(
                        $values,
                        false
                    );
                break;
        }
        $statement = $this->pdo->prepare($SQL);
        (count($values) > 0) ? $statement->execute($values) : $statement->execute();
        return $statement;
    }

    private function prepareValues(array $values, bool $prepare = true)
    {
        if($prepare)
            return implode(",", array_map(fn($m) => "('$m')", $values));
        return implode(",", array_map(fn($m) => "(?)", $values));
    }

    private function prepareFileds(array $fields)
    {
        return implode(",", array_map(fn($f) => "($f)", $fields));
    }

    public function createMigrationClassInstance($migrationFileName)
    {
        require_once __DIR__.'/../migrations/'.$migrationFileName;
        $migrationClassName = pathinfo($migrationFileName, PATHINFO_FILENAME);
        $migrationClassNameWithPath = "app\\migrations\\".$migrationClassName;
        return new  $migrationClassNameWithPath();
    }
}
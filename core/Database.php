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
        $env = new DotEnv();
        $env->load();
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

    public function executeStaments(
        string $table,
        $statementType,
        array $fields,
        array $values = [],
        string $orderBy = "id ASC",
        array $selectFields = [],
    ) {
        $SQL = "";
        $sqlValues = [];
        switch (strtoupper($statementType)) {
            case "SELECT":
                if (count($values) == 0) {
                    if (count($selectFields) > 0) {
                        $SQL = "SELECT ".$this->prepareFileds($selectFields)." FROM ".$table." ORDER BY ".$orderBy;
                    } else {
                        $SQL = "SELECT ".$this->prepareFileds($fields)." FROM ".$table." ORDER BY ".$orderBy;
                    }
                } else {
                    if (count($selectFields) > 0) {
                        $SQL = "SELECT ".$this->prepareFileds(
                                $selectFields
                            )." FROM ".$table." WHERE ".$this->prepareFileds(
                                $fields,
                                true
                            )." ORDER BY ".$orderBy;
                    } else {
                        $SQL = "SELECT ".$this->prepareFileds($fields)." FROM ".$table." WHERE ".$this->prepareFileds(
                                $fields,
                                true
                            )." ORDER BY ".$orderBy;
                    }
                    $sqlValues = $this->prepareValues($values, false, $fields);
                }
                $statement = $this->pdo->prepare($SQL);

                if (count($sqlValues) > 0) {
                    foreach ($sqlValues as $key => $value) {
                        $statement->execute($value);
                    }
                }
                break;
            case "INSERT":
                $SQL = "INSERT INTO ".$table." (".implode(',', $fields).
                    ") VALUES (".
                    $this->prepareFiledsPlaceHolders($fields).")";
                $sqlValues = $this->prepareValues($values, false, $fields);
                $statement = $this->pdo->prepare($SQL);
                if (count($fields) == 1) {
                    foreach ($sqlValues as $key => $value) {
                        $statement->execute($value);
                    }
                } else {
                    foreach ($sqlValues as $sqlValueItem) {
                        foreach ($sqlValueItem as $key => $sqlValue) {
                            $statement->bindValue($key, $sqlValue);
                        }
                    }
                    $statement->execute();
                }
                break;
            /*case "UPDATE":
                break;
            case "DELETE":
                break;*/
            default:
                throw new Exception("Wrong db action");
                break;
        }

        return $statement;
    }

    public function prepareValues(array $values, bool $prepare = true, $fileds = [])
    {
        if ($prepare) {
            return implode(",", array_map(fn($m) => "('$m')", $values));
        }
        $result = [];
        if (count($values) != count($fileds)) {
            foreach ($values as $value) {
                foreach ($fileds as $filed) {
                    $result[] = [':'.$filed => $value];
                }
            }
        } else {
            $result = array_map(fn($f, $v) => [":".$f => $v], $fileds, $values);
        }

        return $result;
    }

    public function prepareFileds(array $fields, bool $forUpdate = false)
    {
        if ($forUpdate) {
            return implode(",", array_map(fn($f) => "$f=:$f", $fields));
        }

        return implode(",", array_map(fn($f) => "($f)", $fields));
    }

    private function prepareFiledsPlaceHolders(array $fields)
    {
        return implode(",", array_map(fn($f) => ":$f", $fields));
    }

    public function createMigrationClassInstance($migrationFileName)
    {
        require_once __DIR__.'/../migrations/'.$migrationFileName;
        $migrationClassName = pathinfo($migrationFileName, PATHINFO_FILENAME);
        $migrationClassNameWithPath = "app\\migrations\\".$migrationClassName;

        return new  $migrationClassNameWithPath();
    }

    public function tableFields($tableName)
    {
        $statement = $this->pdo->prepare("DESCRIBE ".$tableName);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function truncateTable($tableName)
    {
        $statement = $this->pdo->prepare("TRUNCATE ".$tableName);
        $statement->execute();
    }
}
<?php

class Migration
{
    protected $db;

    public function __construct()
    {
        require_once 'Database.php';
        $this->db = new Database();
    }

    public function run($migrationFile)
    {
        require_once $migrationFile;
        $migrationClass = basename($migrationFile, '.php');

        if (class_exists($migrationClass)) {
            $migration = new $migrationClass($this->db);
            $migration->up();
            echo "Migrated: " . $migrationClass . PHP_EOL;
        } else {
            echo "Migration class not found in file: " . $migrationFile . PHP_EOL;
        }
    }

    public function rollback($migrationFile)
    {
        require_once $migrationFile;
        $migrationClass = basename($migrationFile, '.php');

        if (class_exists($migrationClass)) {
            $migration = new $migrationClass($this->db);
            $migration->down();
            echo "Rolled back: " . $migrationClass . PHP_EOL;
        } else {
            echo "Migration class not found in file: " . $migrationFile . PHP_EOL;
        }
    }
}
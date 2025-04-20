<?php

class Db
{

    private $pdo;

    public function __construct()
    {
        try {
            $dsn = "mysql:host=" . Config::$dbHost . ";dbname=" . Config::$dbName . ";charset=utf8mb4";
            $this->pdo = new PDO($dsn, Config::$dbUser, Config::$dbPass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,              // ← qui!
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Connessione fallita: " . $e->getMessage());
        }
    }

    // --- CRUD ---
    public function select($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }

    public function update($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    public function delete($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    // --- Tabelle ---
    public function createTable($tableName, $columns)
    {
        $query = "CREATE TABLE IF NOT EXISTS `$tableName` ($columns) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        return $this->pdo->exec($query);
    }

    public function dropTable($tableName)
    {
        $query = "DROP TABLE IF EXISTS `$tableName`";
        return $this->pdo->exec($query);
    }

    // --- Utilità ---
    public function raw($query)
    {
        return $this->pdo->query($query);
    }

    public function exec($query)
    {
        return $this->pdo->exec($query);
    }
}

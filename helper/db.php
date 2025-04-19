<?php

class db
{
    private $host = 'localhost';
    private $dbname = 'soccer_manager';
    private $username = 'root';
    private $password = 'Matteo00';
    private $pdo;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
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

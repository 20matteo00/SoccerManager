<?php

class table
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function crea_utenti()
    {
        $this->db->createTable('utenti', '
        id INT AUTO_INCREMENT PRIMARY KEY, 
        username VARCHAR(50) NOT NULL, 
        password VARCHAR(255) NOT NULL, 
        email VARCHAR(100) NOT NULL,
        params JSON,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');
    }

    public function crea_stati()
    {
        $this->db->createTable('stati', '
        id INT AUTO_INCREMENT PRIMARY KEY, 
        nome VARCHAR(100) NOT NULL,
        descrizione TEXT,
        params JSON,
        parent_id INT DEFAULT NULL,
        FOREIGN KEY (parent_id) REFERENCES stati(id) ON DELETE SET NULL
        ');
    }

    public function crea_competizioni()
    {
        $this->db->createTable('competizioni', '
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descrizione TEXT,
        params JSON,
        stato_id INT NOT NULL,
        FOREIGN KEY (stato_id) REFERENCES stati(id) ON DELETE CASCADE
        ');
    }

    public function crea_squadre()
    {
        $this->db->createTable('squadre', '
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descrizione TEXT,
        params JSON,
        stato_id INT NOT NULL,
        FOREIGN KEY (stato_id) REFERENCES stati(id) ON DELETE CASCADE
        ');
    }
}

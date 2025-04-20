<?php

class Table
{
    private $db;
    private $continenti = [
        'Africa',
        'America del Nord',
        'America del Sud',
        'Asia',
        'Europa',
        'Oceania'
    ];
    private $stati = [
        'Italia',
        'Francia',
        'Germania',
        'Spagna',
        'Portogallo',
        'Inghilterra',
        'Olanda',
        'Belgio',
        'Svezia',
        'Danimarca',
        'Norvegia',
        'Finlandia',
        'Polonia',
        'Cechia',
        'Slovacchia',
        'Ungheria',
        'Austria',
        'Svizzera'
    ];

    public function __construct($db)
    {
        $this->db = $db;
        $this->crea_utenti();  // Crea la tabella utenti
        $this->crea_stati(); // Crea la tabella stati
        $this->crea_competizioni(); // Crea la tabella compitizioni
        $this->crea_squadre(); // Crea la tabella squadre

        $this->inserisci_stati(); // Inserisce gli stati nella tabella stati
    }

    public function crea_utenti()
    {
        $this->db->createTable('utenti', '
        username VARCHAR(50) NOT NULL PRIMARY KEY, 
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

    public function inserisci_stati()
    {
        // 1) Mondo
        $this->db->insert(
            "INSERT IGNORE INTO stati (id, nome, parent_id) VALUES (?, ?, ?)",
            [1, 'Mondo', null]
        );

        // 2) Continenti: ID 2–7, parent_id = 1
        foreach ($this->continenti as $i => $continent) {
            $id = $i + 2;          // Africa=>2, America Nord=>3, …, Oceania=>7
            $this->db->insert(
                "INSERT IGNORE INTO stati (id, nome, parent_id) VALUES (?, ?, ?)",
                [$id, $continent, 1]
            );
        }

        // 3) Stati europei: partono da ID 8, parent_id = 6 (Europa)
        $baseId = count($this->continenti) + 2; // = 6 (Europa) + 2 = 8
        foreach ($this->stati as $j => $state) {
            $id = $baseId + $j;   // Italia=>8, Francia=>9, …
            $this->db->insert(
                "INSERT IGNORE INTO stati (id, nome, parent_id) VALUES (?, ?, ?)",
                [$id, $state, 6]
            );
        }

        // 4) Personalizzato
        $this->db->insert(
            "INSERT IGNORE INTO stati (id, nome, parent_id) VALUES (?, ?, ?)",
            [99999, 'Personalizzato', null]
        );
    }
}

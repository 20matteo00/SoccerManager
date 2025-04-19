<?php

class Config {
    // Percorsi principali (possono essere usati nei menu o nei router)
    public static array $menu = [
        'Stati' => '#',
        'Competizioni' => '#',
        'Squadre' => '#'
    ];

    // Impostazioni del database
    public static string $dbHost = 'localhost';
    public static string $dbName = 'soccer_manager';
    public static string $dbUser = 'root';
    public static string $dbPass = 'Matteo00';
}
